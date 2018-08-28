<?php
namespace app\components;
/*
 * @author awsaf anam <awsaf.anam@gmail.com>
 * @copyright Copyright &copy; Awsaf -
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
*/
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class Mailer extends Component
{
    
    protected $mailStart = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; margin: 0; padding: 0;">
';
    protected $mailEnd = '
    </body>
</html>';
    protected $_macroData = [];
    
    
    /* not finished */ 
    public function send($to, $type, $data = [] , $attachments = [])
    {
        $data = array_merge($data, $this->getMacroData());

        $camp = $this->getCampaign($type);

        if($camp === null) 
            throw new InvalidConfigException;
        
        $mail = Yii::$app->mailer->compose(NULL);
        $keys = $vals = [];
        foreach ($data as $k=>$v) {
            $keys[] = '{{' . $k . '}}';
            $vals[] = $v;
        }
        $body = str_replace($keys, $vals, $camp->template->content);
        
        $mail->setHtmlBody($this->mailStart . $body . $this->mailEnd);
        $mail->setTextBody(strip_tags($body));

        $config = (new \yii\db\Query())
                                ->select(['from_name', 'from_email'])
                                ->from('email_config')
                                ->where(['default'=>1])
                                ->one();
        $mail->setFrom([$config['from_email'] => $config['from_name']]);
        $mail->setTo($to);
        $mail->setBcc(['info@nsscgroup.com']);
        $mail->setSubject($camp->template->subject);
        if(!empty($attachments)) {
            foreach ($attachments as $attachment) {
                if(is_array($attachment)) {
                    $mail->attach($attachment['path'], ['fileName'=>$attachment['name']]);
                } else {
                    $mail->attach($attachment);
                }
            }
        }
        $mail->send();   
    }
    public function rawSend($to, $subject, $content)
    {
        $mail = Yii::$app->mailer->compose(NULL);
        
        $body = $content;
        
        $mail->setHtmlBody($this->mailStart . $body . $this->mailEnd);
        $mail->setTextBody(strip_tags($body));

        $config = (new \yii\db\Query())
                                ->select(['from_name', 'from_email'])
                                ->from('email_config')
                                ->where(['default'=>1])
                                ->one();
        
        $mail->setFrom([$config['from_email'] => $config['from_name']]);
        $mail->setTo($to);
        $mail->setSubject($subject);
        
        $mail->send();   
    }
    
    protected function getMacroData()
    {
        if(empty($this->_macroData)) {
            $settings= \app\models\Setting::find()->all();

            foreach($settings as $setting) {
                $this->_macroData[$setting->name] = $setting->value;
            }
        }
        return $this->_macroData;
    }

    protected function getCampaign($name) {
        return \app\models\EmailCampaign::find()->with('template')->where(['title' => $name])->one();
    }
}
