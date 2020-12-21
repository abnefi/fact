<?php
/**
 * Created by IntelliJ IDEA
 * User: gnacadja
 * Date: 27/08/2018
 * Time: 15:57
 */

namespace AppBundle\Service;

use Swift_Mailer;
use Symfony\Component\Templating\EngineInterface as Templating;
use Symfony\Component\DependencyInjection\Container as Container;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class Email {

    //On crée deux variables qui vont récupérer les deux services appelé dans la définition du service owo_msp.email
    private $mailer;//Pour récupérer le service mailer
    private $container;
    private $mail_user;
    //Le constructeur initialise au départ les deux services et les stocke dans les deux variables créées ci-dessus
    public function __construct(\Swift_Mailer $mailer, Container $container, $mail_user)
    {
        $this->mailer = $mailer;// Le service Swift_Mailer
        $this->container = $container;
        $this->mail_user = $mail_user;
    }

    public function sender($sujet, $emailDestinataires, $template, array $ccAdresses = [], $attachement = null, $from = 'IGO-Facturation')
    {
        if(!$emailDestinataires) {
            return false;
        }
        if (!is_array($from)) {
            $from = ['africabourse@africabourse.com' => $from];
        }
        //On crée un objet message du type Swift_Message
        $mes = $this->message = \Swift_Message::newInstance()->setSubject($sujet)
            ->setFrom($from)
            ->setTo($emailDestinataires)
            ->setCc($ccAdresses)
            ->setBody(
                $template,
                'text/html'
            );
        if($attachement !== null) {
            if (is_array($attachement)) {
                foreach ($attachement as $item) {
                    $mes->attach($item);
                }
            }else{
                $mes->attach($attachement);
            }
        }
        return $this->mailer->send($mes);
        //return $this->template->renderResponse('Message envoyé');
    }

    public function messageBody($name, $encheance_in, $type_assurance, $agence, $nouveau = true) {
        if ($nouveau){
            $renouvellement = 'souscrire a';
        }else{
            $renouvellement = 'renouveller';
        }
        return "
<h4>Bonjour monsieur {$name}</h4>
<p>
  Ce mail vous ait envoyé pour vous rappeler que votre contrat d'assurance <b>{$type_assurance}</b><br>
  Arrive a échéance dans <b>{$encheance_in} jours</b>. <br>
  Merci de passée à <b>{$agence}</b> pour {$renouvellement} votre contrat chez nous. <br>
  Merci.
  <br><br>
  Cordialement,<br>
  <b>L'équipe FINANCIA</b>
</p>";
    }
}