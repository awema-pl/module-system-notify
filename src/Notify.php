<?php


namespace AwemaPL\SystemNotify;

use Illuminate\Support\Facades\Session;

class Notify
{
    /**
     * Alert id in stack
     *
     * @var string
     */
    protected $id;

    /**
     * Configuration options.
     *
     * @var array
     */
    protected $config;

    /**
     * Notify constructor.
     */
    public function __construct()
    {
        $this->id = uniqid();
        $this->setDefaultConfig();
    }

    /**
     * Sets all default config options for an alert.
     *
     * @return void
     */
    protected function setDefaultConfig()
    {
        $this->config = [
            'title' => '',
            'message' => '',
            'status' => config('system-notify.status'),
            'to' => config('system-notify.container')
        ];
    }

    /**
     * Flash a message.
     *
     * @param string $title
     * @param string $message
     * @param string|null $status
     * @return $this
     */
    public function notify(string $title = '', string $message = '', ?string $status = null)
    {
        $this->config['title'] = $title;
        $this->config['message'] = $message;
        if (!is_null($status)) {
            $this->config['status'] = $status;
        }
        $this->flash();

        return $this;
    }

    public function withButton(array $config = [])
    {
        $this->config['button'] = $config;
        
        return $this;
    }

    /**
     * Display a success status alert message with a message and a title.
     *
     * @param string $title
     * @param string $message
     * @return $this
     */
    public function success(string $title = '', string $message = '')
    {
        $this->notify($title, $message, 'success');

        return $this;
    }

    /**
     * Display a info status alert message with a message and a title.
     *
     * @param string $title
     * @param string $message
     * @return $this
     */
    public function info(string $title = '', string $message = '')
    {
        $this->notify($title, $message, 'info');

        return $this;
    }

    /**
     * Display a warning status alert message with a message and a title.
     *
     * @param string $title
     * @param string $message
     * @return $this
     */
    public function warning(string $title = '', string $message = '')
    {
        $this->notify($title, $message, 'warning');

        return $this;
    }

    /**
     * Display a error status alert message with a message and a title.
     *
     * @param string $title
     * @param string $message
     * @return $this
     */
    public function error(string $title = '', string $message = '')
    {
        $this->notify($title, $message, 'error');

        return $this;
    }

    /**
     * Positioned notification dialog
     *
     * @param string $container
     * @return Notify
     */
    public function to(string $container): self
    {
        Session::forget("notify.{$this->config['to']}.{$this->id}");
        $this->config['to'] = $container;
        $this->flash();

        return $this;
    }

    /**
     * Flash the config options for alert.
     *
     * @return void
     */
    public function flash()
    {
        Session::flash("notify.{$this->config['to']}.{$this->id}", $this->config);
    }

    /**
     * Extract notifications for specified container
     *
     * @param $container
     * @return false|string
     */
    public function extract($container)
    {
        $notifications = Session::pull("notify.$container");
        $notifications = array_values($notifications);
        $notifications = array_unique($notifications, SORT_REGULAR);

        return json_encode($notifications);
    }
}
