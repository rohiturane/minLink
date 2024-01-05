<?php
namespace App\Services;

use EmailValidator\EmailValidator;

class DeveloperService
{
    public function emailValidator($items = [])
    {
        $config = [
            'checkMxRecords' => true,
            'checkBannedListedEmail' => true,
            'checkDisposableEmail' => true,
            'checkFreeEmail' => true,
            //'bannedList' => $bannedDomainList,
            //'disposableList' => $customDisposableEmailList,
            //'freeList' => $customFreeEmailList,
        ];
        $validator = new EmailValidator($config);
        $emails = explode(',', $items['emails']);
        $data = [];
        $error = [];
        foreach($emails as $email)
        {
            $emailIsValid = $validator->validate($email);
            if($emailIsValid)
            {
                $data['valid'][] = $email;
            } else {
                $data['invalid'][] = $email;
                $error[$email] = $validator->getErrorReason();
            }
            // if ($validator->isGmailWithPlusChar()) {
            //     printf(
            //         ' (Sanitized address: %s)',
            //         $validator->getGmailAddressWithoutPlus()
            //     );
            // }
            return ['data' => $data, 'error' => $error];
        }
    }
}