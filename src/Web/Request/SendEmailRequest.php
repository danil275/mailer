<?php
declare(strict_types=1);

namespace App\Web\Request;

use Symfony\Component\Validator\Constraints as Assert;

class SendEmailRequest
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $to;

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $from;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public string $subject;

    #[Assert\NotBlank]
    public string $body;
}
