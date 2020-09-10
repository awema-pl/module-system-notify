<?php

if (!function_exists('alert')) {
    /**
     * Return app instance of Notify.
     *
     * @return \AwemaPL\SystemNotify\Notify
     */
    function alert($title = null, $message = '', $status = null)
    {
        $notify = app('awema-pl_system-notify');
        if (!is_null($title)) {
            return $notify->notify($title, $message, $status);
        }
        return $notify;
    }
}
