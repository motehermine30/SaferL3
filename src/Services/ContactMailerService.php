<?php 
namespace App\Services;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class ContactMailerService{
      /**
         * @var MailerInterface
         */
        private $mailer;
        /**
         * @var Environment
         */
        private $twig;
        /**
         * Mailer constructor
         *
         * @param MailerInterface $mailer
         * @param Environment $twig
         */
        public function __construct(MailerInterface $mailer, Environment $twig)
        {
            $this->mailer = $mailer;
            $this->twig = $twig;
            
        }

        public function send(
            string $subject, 
            string $from, 
            string $to, 
            string $template, 
            array $parameters): void
        {
            $email = (new Email())
                ->from($from)
                ->to($to)
                ->subject($subject)
                ->html(
                    $this->twig->render($template, $parameters),
                    'text/html'
                );
    
            $this->mailer->send($email);
        }
}