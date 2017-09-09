<?php
//定义常量token 
define('TOKEN','dhsilvan'); 
    
//检查标签
    function checkSignature()
    {
        //先获取到这三个参数
        $signature = $_GET['signature'];   
        $nonce = $_GET['nonce']; 
        $timestamp = $_GET['timestamp']; 
              //把这三个参数存到一个数组里面
        $tmpArr = array($timestamp,$nonce,TOKEN); 
        //进行字典排序
        sort($tmpArr);  
    
        //把数组中的元素合并成字符串，impode()函数是用来将一个数组合并成字符串的
        $tmpStr = implode($tmpArr);  
        //sha1加密，调用sha1函数
               $tmpStr = sha1($tmpStr);
        //判断加密后的字符串是否和signature相等
        if($tmpStr == $signature) 
        {
            
            return true;
        }
        return false;
    }
//如果相等，验证成功就返回echostr
    if(checkSignature())
     {    
        //返回echostr
        $echostr = $_GET['echostr'];
        if($echostr)   
        {
            echo $echostr;
            exit;
        }
    }

    function responseMsg(){

    //get post data, May be due to the different environments
    $postStr = $GLOBALS["HTTP_RAW_POST_DATA"]; //接收微信发来的XML数据

    //extract post data
    if(!empty($postStr)){

        //解析post来的XML为一个对象$postObj
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

        $fromUsername = $postObj->FromUserName; //请求消息的用户
        $toUsername = $postObj->ToUserName; //"我"的公众号id
        $keyword = trim($postObj->Content); //消息内容
        $time = time(); //时间戳
        $msgtype = 'text'; //消息类型：文本
        $textTpl = "<xml>
      <ToUserName><![CDATA[%s]]></ToUserName>
      <FromUserName><![CDATA[%s]]></FromUserName>
      <CreateTime>%s</CreateTime>
      <MsgType><![CDATA[%s]]></MsgType>
      <Content><![CDATA[%s]]></Content>
      </xml>";

        if($keyword == 'hehe'){
            $contentStr = 'hello world!!!';
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgtype, $contentStr);
            echo $resultStr;
            exit();
        }else{
            $contentStr = '输入hehe试试';
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgtype, $contentStr);
            echo $resultStr;
            exit();
        }

    }else {
        echo "";
        exit;
    }
        if($postObj->MsgType == 'event'){ //如果XML信息里消息类型为event
            if($postObj->Event == 'subscribe'){ //如果是订阅事件
                $contentStr = "欢迎订阅misaka去年夏天！\n更多精彩内容：http://blog.csdn.net/misakaqunianxiatian";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgtype, $contentStr);
                echo $resultStr;
                exit();
            }
        }
}
?>
