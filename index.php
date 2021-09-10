<?php
$req = file_get_contents("php://input");
file_put_contents("request.log", $req);
$req_arr = json_decode($req, true);

//=======================================================================================================
// Create new webhook in your Discord channel settings and copy&paste URL
//=======================================================================================================
$url = "https://discord.com/api/webhooks/885531110405181462/JZfdTXSETZFgVSSx3aqNMIULDO9nTXoIqjuB844pOen75OEnr5Zwhp4NaZDMsPFHzcLc";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
    "Content-Type: application/json",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);


$repository = $req_arr["repository"]['name'];
$sender = $req_arr["sender"]['login'];
$data['username'] = $req_arr["repository"]["owner"]["avatar_url"];
$img_name = $req_arr["repository"]["owner"]["avatar_url"];
$image = imagecreatefrompng($img_name);
$new_img = imagescale($image, 50, 50);
imagepng($new_img, 'slika.png'); //for png
$data['embeds'][]['image']['url'] = "https://12e9-212-200-201-182.ngrok.io/mobile_shop/slika.png";
switch ($req_arr['action']) {
    case "created":
        $data['content'] = "User $sender like your repositorium $repository";
        break;
    case "deleted":
        $data['content'] = "User $sender dislike your repositorium $repository";
        break;
}
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
echo json_encode($data);
