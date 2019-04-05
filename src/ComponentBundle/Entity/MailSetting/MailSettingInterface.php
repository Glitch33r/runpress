<?php

namespace ComponentBundle\Entity\MailSetting;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface MailSettingInterface
{
    /**
     * @return string|null
     */
    public function getSmtpHost(): ?string;

    /**
     * @param string $smtpHost
     */
    public function setSmtpHost(string $smtpHost): void;

    /**
     * @return string|null
     */
    public function getSmtpUsername(): ?string;

    /**
     * @param string $smtpUsername
     */
    public function setSmtpUsername(string $smtpUsername): void;

    /**
     * @return string|null
     */
    public function getSmtpPassword(): ?string;

    /**
     * @param string $smtpPassword
     */
    public function setSmtpPassword(string $smtpPassword): void;

    /**
     * @return string|null
     */
    public function getSmtpPort(): ?string;

    /**
     * @param string $smtpPort
     */
    public function setSmtpPort(string $smtpPort): void;
}
