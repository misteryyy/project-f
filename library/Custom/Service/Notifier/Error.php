<?php
Class Custom_Service_Notifier_Error
{
	protected $_environment;
    protected $_mailer;
    protected $_session;
    protected $_cookies;
    protected $_error;
    protected $_profilers;

    public function __construct(
        $environment,
        ArrayObject $error,
        Zend_Mail $mailer,
        Zend_Session_Namespace $session,
        Array $cookies,
        Array $server)
    {
        $this->_environment = $environment;
        $this->_mailer = $mailer;
        $this->_error = $error;
        $this->_session = $session;
        $this->_cookies = $cookies;
        $this->_server = $server;
    }

    public function getFullErrorMessage()
    {
        $message = '';

        if (!empty($this->_server['SERVER_ADDR'])) {
            $message .= "Server IP: " . $this->_server['SERVER_ADDR'] . "\n";
        }

        if (!empty($this->_server['HTTP_USER_AGENT'])) {
            $message .= "User agent: " . $this->_server['HTTP_USER_AGENT'] . "\n";
        }

        if (!empty($this->_server['HTTP_X_REQUESTED_WITH'])) {
            $message .= "Request type: " . $this->_server['HTTP_X_REQUESTED_WITH'] . "\n";
        }
        $message .= "Server time: " . date("Y-m-d H:i:s") . "\n";
        $message .= "RequestURI: " . $this->_error->request->getRequestUri() . "\n";

        if (!empty($this->_server['HTTP_REFERER'])) {
            $message .= "Referer: " . $this->_server['HTTP_REFERER'] . "\n";
        }

        $message .= "Message: " . $this->_error->exception->getMessage() . "\n\n";
        $message .= "Trace:\n" . $this->_error->exception->getTraceAsString() . "\n\n";
        $message .= "Request data: " . var_export($this->_error->request->getParams(), true) . "\n\n";

        $it = $this->_session->getIterator();

        $message .= "Session data:\n\n";
        foreach ($it as $key => $value) {
            $message .= $key . ": " . var_export($value, true) . "\n";
        }
        $message .= "\n";

        $message .= "Cookie data:\n\n";
        foreach ($this->_cookies as $key => $value) {
            $message .= $key . ": " . var_export($value, true) . "\n";
        }
        $message .= "\n";

        return $message;
    }

    public function notify()
    {
        if (!in_array($this->_environment, array('production', 'testing'))) {
            return false;
        }

        $this->_mailer->setFrom('do-not-reply@YUUR_APP_DOMAIN');
        $this->_mailer->setSubject("Exception on Zend Application Implementation");
        $this->_mailer->setBodyText($this->getFullErrorMessage());
        $this->_mailer->addTo('YOUR_SUPPORT_EMAIL_ADDRESS');

        return $this->_mailer->send();
    }
}