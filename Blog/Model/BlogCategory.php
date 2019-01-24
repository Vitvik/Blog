<?php
namespace Vitvik\Blog\Model;

class BlogCategory extends \Magento\Framework\Model\AbstractModel
{

    public function prepareCategoriesId($data){
        $categoriesId =[];
        foreach ($data as $arr){
            foreach ($arr as $item => $value){
                $categoriesId = $value;
            }
        }
        return $categoriesId;
    }





}