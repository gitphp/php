<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 校验请求是否合法
 *
 * @author		zhut
 * @since		2018-010-05
 *
 */
class Valid_access
{
    //请求接口时传递过来的get或post参数
    private $request_params;
    //请求接口时传递过来的ip
    private $request_ip;

    //默认返回的数据
    public $data = array(
        'status' => 0
    );

    public function __construct($data = '')
    {
        $this->ci =& get_instance();
        if (!empty($data['params'])) {
            $this->request_params = $data['params'];
            $this->request_ip= $data['ip'];
        } else {
                //logger('debug', 'Error', 'Class Valid_access inits fail,params is null');
            $this->data['errorCode'] = 4007;
            http_response($this->data);
        }
    }


    //校验请求是否合法
    function check_access()
    {
        //请求参数
        $params = $this->request_params;
//        $ip=$this->request_ip;
        $valid_token = $this->_get_token($params['system_code']);

        if (!isset($params['token'])) {;
            $this->data['errorCode'] = 4007;
            http_response($this->data);
        }
        $token = strtolower($params['token']);
        //密钥
        $api_secret = $valid_token;

        unset($params['token']);
        //生成token
        $params = ascSort($params);
    
        $new_token = strtolower(md5(createLinkstring($params) . $api_secret));

        if ($new_token != $token) {
            $this->data['errorCode'] = 4003;
            http_response($this->data);
        }
    }

    //获取访问系统的Token
    private function _get_token($system_code){
        if (empty($system_code)){
            $this->data['errorCode'] = 4003;
            http_response($this->data);
        }

        $secret_token = VISIT_TOKEN;

        return $secret_token;
    }

    //IP拦截
    public function check_ip(){
        if ($this->request_ip != VISIT_IP){
            $this->data['errorCode'] = 4003;
            http_response($this->data);
        }
    }

}
// END CI_Valid_access class
/* End of file Valid_access.php */
/* Location: ./system/libraries/Valid_access.php */

?>
