<?php

/* * '
 * 验证码生成类
 */

class YucCaptcha {

    protected $width; //验证码宽度
    protected $height; //验证码长度
    protected $codeNum; //验证码字符个数
    protected $codeType; //验证码类型
    protected $fontSize; //字符大小
    protected $fontType; //字体类型
    protected $codeStr; //中文内容
    protected $strNum; //中文个数
    protected $imageType; //输出图片类型
    protected $image; //图片资源
    protected $checkCode; //验证码内容

    /**
    +--------------------------------------------------------------------------------
     * 取得验证码信息
    +--------------------------------------------------------------------------------
     * @param integer $width        验证码宽度
     * @param integer $height        验证码高度
     * @param integer $codeNum        验证码字符个数
     * @param integer $codeType    验证码字符类型    1为数字 2为字母 3为汉字 4为混编
     * @param integer $fontSize        验证码字体的大小
     * @param string  $imageType    验证码输出图片类型
     * @param string $codeStr
     * @internal param string $fontType 验证码字体类型
     * @internal param string $codestr 中文验证码内容
    +--------------------------------------------------------------------------------
     */

    public function __construct($width = 100, $height = 50, $codeNum = 4, $codeType = 4, $fontSize = 12, $imageType = 'jpeg', $codeStr = '去我饿人他一哦平啊是的飞个好就看了在想才吧你吗') {
        $this->width = $width;
        $this->height = $height;
        $this->codeNum = $codeNum;
        $this->codeType = $codeType;
        $this->fontSize = $fontSize;
        $this->codeStr = $codeStr;
        $this->strNum = strlen($this->codeStr) / 3 - 1;
        $this->imageType = $imageType;
        $this->checkCode = '';
    }


    //+--------------------------------------------------------------------------------
    //* 分配画布资源
    //+--------------------------------------------------------------------------------
    protected function createRes() {
        $this->image = imagecreatetruecolor($this->width, $this->height);
    }

    //+--------------------------------------------------------------------------------
    //* 填充背景颜色
    //+--------------------------------------------------------------sanzi0930@163.com------------------

    protected function bgColor() {
        $write = imagecolorallocate($this->image, 255, 255, 255);
        imagefill($this->image, 0, 0, $write);
    }

    //+--------------------------------------------------------------------------------

    /**
     * 增加干扰字符
     */
    protected function fillWords($factor = 30) {
        if ($factor === NULL) {
            return FALSE;
        }
        $words = array(
            0,
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            'a',
            'b',
            'c',
            'd',
            'e',
            'f',
            'g',
            'h',
            'i',
            'j',
            'k',
            'l',
            'm',
            'n',
            'o',
            'p',
            'q',
            'r',
            's',
            't',
            'u',
            'v',
            'w',
            'x',
            'y',
            'z',
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'O',
            'P',
            'Q',
            'R',
            'S',
            'T',
            'U',
            'V',
            'W',
            'X',
            'Y',
            'Z'
        );
        $font_size = $factor;
        for ($i = 1; $i < $this->width - 1; $i += $font_size + 5) {
            for ($j = 1; $j < $this->height - 1; $j += $font_size + 5) {
                $c = mt_rand(-50, 50);
                imagettftext($this->image, $font_size, $c, $i, $j, $this->randColor(190, 220), M_PRO_DIR . '/Media/Font/Jura.ttf', $words[mt_rand(0, 61)]);
            }
        }
    }

    /**
     *  增加干扰点
     */
    protected function generateDisturb($words = 30) {
        $this->fillWords($words);
    }

    /**
     *  画边框
     */
    protected function bgBorder() {
        $bordercolor = imagecolorallocate($this->image, 0x9d, 0x9e, 0x96);
        imagerectangle($this->image, 0, 0, $this->width - 1, $this->height - 1, $bordercolor);
    }

    /**
     *  随机生成背景色
     * @param int $mix
     * @param int $max
     * @return type
     */
    protected function randColor($mix = 0, $max = 255) {
        $fontColor = imagecolorallocate($this->image, mt_rand($mix, $max), mt_rand($mix, $max), mt_rand($mix, $max));
        return $fontColor;
    }

    /**
     *  创建 提示信息
     */
    protected function CreateTip($tip) {
        imagettftext($this->image, 9, 0, 5, $this->height - 5, $this->randColor(0, 20), M_PRO_DIR . '/Media/Font/Jura.ttf', $tip);
    }

    //+--------------------------------------------------------------------------------
    //* 把字符写到画布上去
    //+--------------------------------------------------------------------------------

    protected function writeText($rndstring) {
        $this->checkCode = implode('', $rndstring);
        $i = 0;
        foreach ($rndstring as $code) {
            $c = mt_rand(-30, 30);
            $x = floor($this->width / $this->codeNum) * $i + 5;
            $y = $this->height / 2 + $this->fontSize / 2;
            imagettftext($this->image, $this->fontSize, $c, $x, $y, $this->randColor(0, 200), M_PRO_DIR . '/Media/Font/Jura.ttf', $code);
            $i++;
        }
    }

    /**
     * 添加说明
     * @param type $word
     */
    protected function writeDes($word) {
        imagettftext($this->image, 12, 0, 10, $this->height / 2, imagecolorallocate($this->image, 255, 0, 0), M_PRO_DIR . '/Media/Font/Jura.ttf', $word);
    }

    //+--------------------------------------------------------------------------------
    //* 输出图片格式
    //+--------------------------------------------------------------------------------
    protected function output() {
        $func = 'image' . $this->imageType;
        $header = 'Content-type:image/' . $this->imageType;
        if (function_exists($func)) {
            header($header);
            $func($this->image);
        } else {
            echo '本系统不支持此方法';
            return FALSE;
        }
    }

    //+--------------------------------------------------------------------------------
    //* 输出验证码
    //+--------------------------------------------------------------------------------
    public function showImage($code) {
        $this->createRes();
        $this->bgColor();
        $this->generateDisturb();
        $this->bgBorder();
        $this->writeText($code);
        $this->output();
    }

    static public function showComplexImage($code, $words = 20, $codeNum = 4, $codeType = 2, $width = 160, $height = 90, $fontSize = 36, $tip = '') {
        $captcha = new YucCaptcha($width, $height, $codeNum, $codeType, $fontSize);
        $captcha->createRes();
        $captcha->bgColor();
        $captcha->fillWords($words);
        $captcha->CreateTip($tip);
        $captcha->writeText($code);
        $captcha->bgBorder();
        $captcha->output();
        return $captcha->getCodeResult();
    }

    static public function showImgDesc($word, $tip = '', $width = 160, $height = 90, $fontSize = 30) {
        $captcha = new YucCaptcha($width, $height, 5, 1, $fontSize);
        $captcha->createRes();
        $captcha->bgColor();
        $captcha->writeDes($word);
        $captcha->CreateTip($tip);
        $captcha->bgBorder();
        $captcha->output();
    }

    /**
     *  返回验证码结果
     * @return type
     */
    public function getCodeResult() {
        return $this->checkCode;
    }

    //+--------------------------------------------------------------------------------
    //* 销毁图片
    //+--------------------------------------------------------------------------------
    public function __destruct() {
        imagedestroy($this->image);
    }

}


