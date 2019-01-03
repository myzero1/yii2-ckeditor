<?php
/**
 * UEditor Widget扩展
 * @author xbzbing<xbzbing@gmail.com>
 * @link www.crazydb.com
 *
 * UEditor版本v1.4.3.1
 * Yii 版本 2.0+
 */
namespace myzero1\ckeditor;

use yii;
use yii\imagine\Image;
use yii\web\Controller;

/**
 * Class UEditorController
 * 负责UEditor后台响应
 * @package crazydb\ueditor
 */
class CKditorController extends Controller
{
    /**
     * UEditor的配置
     * @see http://fex-team.github.io/ueditor/#start-config
     * @var array
     */
    public $config;

    /**
     * 列出文件/图片时需要忽略的文件夹
     * 主要用于处理缩略图管理，兼容比如elFinder之类的程序
     * @var array
     */
    public $ignoreDir = [
        '.thumbnails'
    ];

    /**
     * 缩略图设置
     * 默认不开启
     * ['height' => 200, 'width' => 200]表示生成200*200的缩略图，如果设置为空数组则不生成缩略图
     * @var array
     */
    public $thumbnail = [];

    /**
     * 图片缩放设置
     * 默认不缩放。
     * 配置如 ['height'=>200,'width'=>200]
     * @var array
     */
    public $zoom = [];

    /**
     * 水印设置
     * 参考配置如下：
     * ['path'=>'水印图片位置','position'=>0]
     * 默认位置为 9，可不配置
     * position in [1 ,9]，表示从左上到右下的9个位置。
     * @var array
     */
    public $watermark = [];

    /**
     * 是否允许内网采集
     * 如果为 false 则远程图片获取不获取内网图片，防止 SSRF。
     * 默认为 false
     * @var bool
     */
    public $allowIntranet = false;

    /**
     * 默认 action
     * @var string
     */
    public $defaultAction = 'index';

    /**
     * Web根目录
     * @var string
     */
    protected $webroot;

    public function init()
    {
        parent::init();
        //CSRF 基于 POST 验证，UEditor 无法添加自定义 POST 数据，同时由于这里不会产生安全问题，故简单粗暴地取消 CSRF 验证。
        //如需 CSRF 防御，可以使用 server_param 方法，然后在这里将 Get 的 CSRF 添加到 POST 的数组中。。。
        Yii::$app->request->enableCsrfValidation = false;

        //当客户使用低版本IE时，会使用swf上传插件，维持认证状态可以参考文档UEditor「自定义请求参数」部分。
        //http://fex.baidu.com/ueditor/#server-server_param

        //保留UE默认的配置引入方式
        if (file_exists(__DIR__ . '/config.json'))
            $CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", '', file_get_contents(__DIR__ . '/config.json')), true);
        else
            $CONFIG = [];

        if (!is_array($this->config))
            $this->config = [];

        if (!is_array($CONFIG))
            $CONFIG = [];

        $default = [
            'imagePathFormat' => '/upload/image/{yyyy}{mm}{dd}/{time}{rand:8}',
            'scrawlPathFormat' => '/upload/image/{yyyy}{mm}{dd}/{time}{rand:8}',
            'snapscreenPathFormat' => '/upload/image/{yyyy}{mm}{dd}/{time}{rand:8}',
            'catcherPathFormat' => '/upload/image/{yyyy}{mm}{dd}/{time}{rand:8}',
            'videoPathFormat' => '/upload/video/{yyyy}{mm}{dd}/{time}{rand:8}',
            'filePathFormat' => '/upload/file/{yyyy}{mm}{dd}/{rand:8}_{filename}',
            'imageManagerListPath' => '/upload/image/',
            'fileManagerListPath' => '/upload/file/',
        ];
        $this->config = $this->config + $default + $CONFIG;
        $this->webroot = Yii::getAlias('@webroot');
        if (!is_array($this->thumbnail))
            $this->thumbnail = false;
    }

    /**
     * 上传图片
     */
    public function actionImageUpload()
    {
        if(isset($_FILES['upload'])){
          // ------ Process your file upload code -------
            $filen = $_FILES['upload']['tmp_name']; 
            $con_images = "upload/".$_FILES['upload']['name'];
            move_uploaded_file($filen, $con_images );
            $url = $con_images;

            echo json_encode([
                'uploaded'=>1,
                'fileName'=>$url,
                'url'=>'/'.$url,
            ]);
            exit;
        } else {
            echo "no uploaded file.";
        }
    }

    /**
     * 上传图片
     */
    public function actionFilebrowserImageUpload()
    {
        if(isset($_FILES['upload'])){
          // ------ Process your file upload code -------
            $filen = $_FILES['upload']['tmp_name']; 
            $con_images = "uploaded/".$_FILES['upload']['name'];
            move_uploaded_file($filen, $con_images );
            $url = $con_images;

            $funcNum = $_GET['CKEditorFuncNum'] ;
            // Optional: instance name (might be used to load a specific configuration file or anything else).
            $CKEditor = $_GET['CKEditor'] ;
            // Optional: might be used to provide localized messages.
            $langCode = $_GET['langCode'] ;
            
            // Usually you will only assign something here if the file could not be uploaded.
            $message = '';
            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
        }
    }
}
