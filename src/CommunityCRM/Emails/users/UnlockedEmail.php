<?php

namespace CommunityCRM\Emails;

class UnlockedEmail extends BaseUserEmail
{
    protected function getSubSubject(): string
    {
        return gettext('Account Unlocked');
    }

    protected function buildMessageBody(): string
    {
        return gettext('Your CommunityCRM account was unlocked.');
    }
}
