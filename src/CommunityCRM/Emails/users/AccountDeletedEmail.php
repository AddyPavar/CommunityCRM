<?php

namespace CommunityCRM\Emails;

class AccountDeletedEmail extends BaseUserEmail
{
    protected function getSubSubject(): string
    {
        return gettext('Your Account was Deleted');
    }

    protected function buildMessageBody(): string
    {
        return gettext('Your CommunityCRM Account was Deleted.');
    }
}
