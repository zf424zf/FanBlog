<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/14 0014
 * Time: 下午 8:44
 */

namespace App\Handlers;


class ImageUploadHandler
{
    //允许上传的图片类型
    protected $imgAllowed = [
        'png', 'jpg', 'jpeg', 'gif'
    ];

    /**
     * 图片保存及裁剪
     * @param $file
     * @param $folder
     * @param $filePrefix
     * @param bool $maxWidth
     * @return array|bool
     */
    public function save($file, $folder, $filePrefix, $maxWidth = false)
    {
        //指定存储的相对路径，例如:upload/images/avatars/201808/12
        $folderName = "upload/images/$folder/" . date("Ym/d", time());
        //指定文件存储的物理路径
        $folderPath = public_path() . '/' . $folderName;
        //获取图片后缀名 若不存在则存为png格式
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        //拼接完整的文件名字
        $fileName = $filePrefix . '_' . time() . '_' . str_random(10) . '.' . $extension;

        if (!in_array($extension, $this->imgAllowed)) {
            return false;
        }

        //移动文件到指定文件夹并返回图片完整路径
        $file->move($folderPath, $fileName);

        if ($maxWidth && $extension != 'gif') {
            //如果指定最大宽度并且不是gif图片 进行裁剪
            $this->resize($folderPath . '/' . $fileName, $maxWidth);
        }
        return [
            'path' => config('app.url') . "/$folderName/$fileName"
        ];
    }

    /**
     * 裁剪图片 指定宽度 高度等比缩放
     * @param $filePath
     * @param $maxWidth
     */
    public function resize($filePath, $maxWidth)
    {
        //实例化图片
        $image = \Image::make($filePath);
        $image->resize($maxWidth, null, function ($constraint) {
            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();
            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });
        // 对图片修改后进行保存
        $image->save();
    }
}