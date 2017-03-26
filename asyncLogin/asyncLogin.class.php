<?php
/**
 * Description of asyncLogin
 *
 * @author xianglingchuan
 */
class asyncLogin {
    
    
    private $curl = null;
    
    
    private function curlInit(){
        $this->curl = curl_init();
    }
    
    
    private function curlClose(){
        if($this->curl!=null){
            curl_close($this->curl);
        }
    }
    
    
    //模拟登录 
    public function login_post($url, $cookieFile, $post) { 
        $this->curlInit();
        curl_setopt($this->curl, CURLOPT_URL, $url);//登录提交的地址 
        curl_setopt($this->curl, CURLOPT_HEADER, 0);//是否显示头信息 
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);//是否自动显示返回的信息 
        curl_setopt($this->curl, CURLOPT_COOKIEJAR, $cookieFile); //设置Cookie信息保存在指定的文件中 
        curl_setopt($this->curl, CURLOPT_POST, 1);//post方式提交 
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($post));//要提交的信息 
        curl_exec($this->curl);//执行cURL 
        $rs = curl_multi_getcontent($this->curl);
        //curl_close($curl);//关闭cURL资源，并且释放系统资源 
        $this->curlClose();
        //var_dump("rs===".$rs);
        return $rs;
    } 


    //登录成功后获取数据 
    public function get_content($url, $cookieFile) { 
        $this->curlInit();
        curl_setopt($this->curl, CURLOPT_URL, $url); 
        curl_setopt($this->curl, CURLOPT_HEADER, 0); 
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, $cookieFile); //读取cookie 
        $rs = curl_exec($this->curl); //执行cURL抓取页面内容 
        $this->curlClose();
        return $rs;     
    } 
    
    
}
