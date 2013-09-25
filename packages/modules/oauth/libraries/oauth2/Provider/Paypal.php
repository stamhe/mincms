<?php namespace application\modules\oauth\libraries\oauth2\Provider; 
use application\modules\oauth\libraries\oauth2\Provider;
use application\modules\oauth\libraries\oauth2\Token\Access;
/**
 * PayPal OAuth2 Provider
 *
 * @package    CodeIgniter/OAuth2
 * @category   Provider
 * @author     Phil Sturgeon
 * @copyright  (c) 2012 HapplicationyNinjas Ltd
 * @license    http://philsturgeon.co.uk/code/dbad-license
 */

class Paypal extends Provider
{
    /**
     * @var  string  default scope (useful if a scope is required for user info)
     */
    protected $scope = array('https://identity.x.com/xidentity/resources/profile/me');

    /**
     * @var  string  the method to use when requesting tokens
     */
    protected $method = 'POST';

    public function url_authorize()
    {
        return 'https://identity.x.com/xidentity/resources/authorize';
    }

    public function url_access_token()
    {
        return 'https://identity.x.com/xidentity/oauthtokenservice';
    }

    

}
