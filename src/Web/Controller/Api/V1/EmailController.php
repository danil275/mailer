<?php

declare(strict_types=1);

namespace App\Web\Controller\Api\V1;

use App\Domain\Entity\Email;
use App\Infrastructure\Service\EmailService;
use App\Web\Request\SendEmailRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Cache\CacheInterface;

#[Route('/api/v1', name: 'api_v1_email_')]
class EmailController extends AbstractController
{
    private const TTL = 300;

    #[Route('/send', name: 'send', methods: ['POST'])]
    public function send(
        Request             $request,
        SerializerInterface $serializer,
        ValidatorInterface  $validator,
        EmailService        $emailService,
        CacheInterface      $cache,
    ): JsonResponse
    {

        $key = $request->headers->get('Idempotency-Key');

        if ($key === null) {
            return $this->json([], 409);
        }

        $cacheItem = $cache->getItem('idempotency_' . $key);

        if ($cacheItem->isHit()) {
            $cachedResponse = $cacheItem->get();
            return $this->json(json_decode($cachedResponse), 202);
        }

        $sendEmailRequest = $serializer
            ->deserialize($request->getContent(), SendEmailRequest::class, 'json');

        $errors = $validator->validate($sendEmailRequest);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }

            return $this->json(['errors' => $errorMessages], 422);
        }

        $email = new Email();
        $email->setTo($sendEmailRequest->to);
        $email->setFrom($sendEmailRequest->from);
        $email->setSubject($sendEmailRequest->subject);
        $email->setBody($sendEmailRequest->body);

        $email = $emailService->send($email);

        $responseArray = ['status' => $email->getStatus()->getName(), 'id' => $email->getId()];

        $cacheItem->set(json_encode($responseArray));
        $cacheItem->expiresAfter(self::TTL);
        $cache->save($cacheItem);

        return $this->json($responseArray, 202);
    }

    #[Route('/status/{id}', name: 'status', methods: ['GET'])]
    public function status(
        int          $id,
        EmailService $emailService,
    ): JsonResponse
    {
        $emailStatus = $emailService->status($id);
        return $this->json(['status' => $emailStatus->getName(), 'id' => $id]);
    }

}
