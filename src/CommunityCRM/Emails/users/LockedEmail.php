<?php

namespace CommunityCRM\Emails;

class LockedEmail extends BaseUserEmail
{
    protected function getSubSubject(): string
    {
        return gettext('Account Locked');
    }

    protected function buildMessageBody(): string
    {
        return gettext('Your CommunityCRM account was locked.');
    }
}
