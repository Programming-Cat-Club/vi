//<?php
		$userdata = sprintf($this->conf['emailcontent'],$data['user'],$code);
        $hosttitle = $this->conf['title'];//网站标题 
        $hosturl = WWW;//网站url
        $emailneir = <<<dsds
<div id="mailContentContainer" style="padding: 0px;height: auto;min-height: auto;font-family: Hiragino Sans GB,Microsoft YaHei,Helvetica Neue;">
    <div style="background:#ececec;padding:35px;">
        <table cellpadding="0" align="center" width="600" style="background:#fff;width:600px;margin:0 auto;text-align:left;position:relative;border-radius:5px;font-size:14px;line-height:1.5;box-shadow:0 0 5px #999999;border-collapse:collapse;">
            <tbody>
                <tr>
                    <th valign="middle" style="height:25px;color:#fff; font-size:14px;line-height:25px; font-weight:bold;text-align:left;padding:15px 35px; border-bottom:1px solid #467ec3;background:#518bcb;border-radius:5px 5px 0 0;">
                        <span style="float:left; width: 120px;font-size: 28px;color: #fff;">
                            $hosttitle
                        </span>
                        <span style="font-size: 12px;margin-left: -30px;background-color: #55BAF1;padding: 0 5px;border-radius: 5px;border-top-width: -5;color: #fff;">
                            <a href="$hosturl" style="color:#FFF;text-decoration: none;">$hosturl</a>
                        </span>
                    </th>
                </tr>
                <tr>
                    <td>
                        <div style="padding:35px 35px 40px;"><h2 style="font-weight:normal; font-size:14px;margin:5px 0;"><div><strong>尊敬的用户：</strong></div><p style="color:#313131;line-height:28px;font-size:14px;margin:20px 0 0 0;">您好！收到这封邮件，是由于在 $hosttitle 进行了用户密码找回。如果不是您操作的，请忽略这封邮件。您不需要退订或进行其他进一步的操作。</p><br><div style="padding: 3px;background: #3CBAAE;text-align: center;font-size: 16px;"><font style="color: #fff;">以下是您的用户信息</font></div><div style="text-align: center;width: 488px;font-size: 12px;padding: 10px 20px;border-left: 1px solid #E9E9E9;border-bottom: 1px solid #E9E9E9;border-right: 1px solid #E9E9E9;"><h1 style="word-wrap: break-word;word-break:normal;color: #00BCD4;">$userdata</h1></div><div></div><p style="color:#999; margin:26px 0 0 0; font-size:12px;">感谢您的访问，祝您使用愉快！<span style="background:#ddd;height:1px;width:100%;overflow:hidden;display:block;margin:8px 0;"></span>Powered by $hosttitle 管理团队.<br></p></h2></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
dsds;
        // $flag = $this->sendMail($email,$this->conf['emailtitle'],$emailneir);
        $flag = A('Plugins')->Send_email($email, $this->conf['emailtitle'], $emailneir);

        if(!$flag['error']){
            $this->json(['error'=>$flag['error'],"info"=>$flag['msg']]);
    	}