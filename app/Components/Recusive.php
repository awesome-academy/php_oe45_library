<?php

namespace App\Components;

class Recusive
{
    private $data;

    private $htmlSelect = '';

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function categoryRecusive($parentID, $id = 0, $text = '')
    {
        foreach ($this->data as $value) {
            if ($value['parent_id'] == $id) {
                if (!empty($parentID) && $parentID == $value['cate_id']) {
                    $this->htmlSelect .= "<option selected value='" . $value['cate_id'] . "'>"
                                      . $text . $value['cate_name'] . "</option>";
                } else {
                    $this->htmlSelect .= "<option value='" . $value['cate_id'] . "'>"
                                      . $text . $value['cate_name'] . "</option>";
                }

                $this->categoryRecusive($parentID, $value['cate_id'], $text. '--');
            }
        }
        return $this->htmlSelect;
    }
}
