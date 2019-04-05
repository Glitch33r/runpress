<?php

namespace UserBundle\Mailer;

use UserBundle\Entity\UserInterface;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface MailerInterface
{
    /**
     * Send an email to a user to confirm the account creation.
     *
     * @param UserInterface $user
     */
    public function sendConfirmationEmailMessage(UserInterface $user);

    /**
     * Send an email to a user to confirm the password reset.
     *
     * @param UserInterface $user
     */
    public function sendResettingEmailMessage(UserInterface $user);
}
