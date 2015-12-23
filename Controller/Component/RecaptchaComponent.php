<?php
/**
 * Recaptcha Component
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
namespace Recaptcha\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Http\Client;
use Exception;
use Recaptcha\Recaptcha\Recaptcha;
use Recaptcha\Recaptcha\RecaptchaResponse;

class RecaptchaComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * RecaptchaResponse.
     *
     * @var RecaptchaResponse
     */
    protected $response;

    /**
     * Recaptcha.
     *
     * @var Recaptcha
     */
    protected $recaptcha;

    /**
     * Attach Recaptcha helper to Controller.
     *
     * @param Controller $controller Controller.
     *
     * @return void
     */
    public function setController($controller)
    {
        // Add the helper on the fly
        if (!isset($controller->helpers['Recaptcha.Recaptcha'])) {
            $controller->helpers[] = 'Recaptcha.Recaptcha';
        }
    }

    /**
     * startup callback
     *
     * @param \Cake\Event\Event $event Event.
     *
     * @return void
     */
    public function startup(Event $event)
    {
        $secret = Configure::read('Recaptcha.secret');
        // throw an exception if the secret is not defined in config/recaptcha.php file
        if (empty($secret)) {
            throw new Exception(__d('recaptcha', "You must set the secret Recaptcha key in config/recaptcha.php file"));
        }
        $this->response = new RecaptchaResponse();
        // instantiate Recaptcha object that deals with retrieving data from google recaptcha
        $this->recaptcha = new Recaptcha($this->response, $secret);
        $controller = $event->subject();

        $this->setController($controller);
    }

    /**
     * Verify Response
     *
     * @return bool
     */
    public function verify()
    {
        $controller = $this->_registry->getController();
        if (isset($controller->request->data["g-recaptcha-response"])) {
            $gRecaptchaResponse = $controller->request->data["g-recaptcha-response"];

            $resp = $this->recaptcha->verifyResponse(
                new Client(),
                $gRecaptchaResponse
            );

            // if verification is correct,
            if ($resp) {
                return true;
            }
        }
        return false;
    }
}
