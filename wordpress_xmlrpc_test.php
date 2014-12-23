<?php


require_once("XML/RPC.php");

$host = "wp.localcentos65";
$xmlrpc_path = "/wordpress_sample/xmlrpc.php";
$appkey = '';
$user = 'root';
$passwd ='rootpass';

$c = new XML_RPC_client($xmlrpc_path, $host, 80);
$appkey = new XML_RPC_Value($appkey, 'string');
$username = new XML_RPC_Value( $user, 'string' );
$passwd = new XML_RPC_Value( $passwd, 'string' );

$message = new XML_RPC_Message(
    'blogger.getUsersBlogs',
    array($appkey, $username, $passwd) );

$result = $c->send($message);

if( !$result ){
 	exit('Could not connect to the server.');
}else if( $result->faultCode() ){
 	exit($result->faultString());
}
$blogs = XML_RPC_decode($result->value());

$blog_id = new XML_RPC_Value($blogs[0]["blogid"], "string");

print_r($blog_id);

#####ファイルのアップロード
$image = file_get_contents("/var/www/html/img/1693.jpg");
$file = array(
    "type" => "image/jpeg",
    "bits" => new XML_RPC_Value($image, "base64"),
    "name" => new XML_RPC_Value("filename.jpg", "string"),
);
$file = new XML_RPC_Value($file, "struct");
$message = new XML_RPC_Message(
    'wp.uploadFile',
    array($blog_id, $username, $passwd, $file)
);
$result = $c->send($message);
if( !$result ){
    exit('Could not connect to the server.');
}else if( $result->faultCode() ){
    exit($result->faultString());
}
$resp = XML_RPC_decode($result->value());
$image_url = $resp["url"];
echo '$image_url:'.$image_url;

####記事の投稿
$title = 'XML-RPCテスト';
$categories = array(
    new XML_RPC_Value("日記", "string"),
    new XML_RPC_Value("写真", "string")
);
$description = "ここに本文を入れます。<p>HTML も書けます</p><img src='".$image_url."'>";
$content = new XML_RPC_Value(
    array(
        'title' => new XML_RPC_Value($title, 'string'),
        'categories' => new XML_RPC_Value($categories, 'array'),
        'description' => new XML_RPC_Value($description, 'string'),
        'dateCreated' => new XML_RPC_Value(time(), 'dateTime.iso8601')
    ),
    'struct');
$publish = new XML_RPC_Value(1, "boolean");
$message = new XML_RPC_Message(
    'metaWeblog.newPost',
    array($blog_id, $username, $passwd, $content, $publish));

$result = $c->send($message);

if( !$result ){
    exit('Could not connect to the server.');
}else if( $result->faultCode() ){
    exit($result->faultString());
}
$post_id = XML_RPC_decode($result->value());



