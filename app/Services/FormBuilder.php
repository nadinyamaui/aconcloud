<?php

/**
 * Description of FormMacros
 *
 * @author nadinarturo
 */

namespace App\Services;

use Collective\Html\FormBuilder as BaseFormBuilder;

class FormBuilder extends BaseFormBuilder
{
    public function model($model, array $options = [])
    {
        if ($model->id && !isset($options['dont_create_url'])) {
            $options['url'] .= '/' . $model->id;
            $options['method'] = 'PUT';
        } else {
            $options['method'] = 'POST';
        }

        return parent::model($model, $options);
    }

    public function bootstrap($name, $value, $label, $numCols = 6, $editor = false, $type = "text")
    {
        if ($editor) {
            $params['class'] = 'form-control ckeditor';
            $type = 'textarea';
        } else {
            $params['class'] = 'form-control';
        }
        $params['id'] = $name;
        $params['placeholder'] = $label;

        return view('templates.bootstrap.input_only',
            compact('name', 'value', 'label', 'numCols', 'type', 'params', 'editor'))->render();
    }

    public function displaySimple($obj, $attrName)
    {
        $value = $obj->getValueAt(str_replace('[]', '', $attrName), true);
        $label = $obj->getDescription($attrName);

        return "<b>$label: </b> $value";
    }

    public function display($obj, $attrName, $numCols = 12)
    {
        $data['numCols'] = $numCols;
        $data['attrName'] = $attrName;
        $data['params']['id'] = str_replace('[]', '', $attrName);
        $data['attrValue'] = $obj->getValueAt($data['params']['id'], true);
        $data['attrLabel'] = $obj->getDescription($attrName);
        $data['obj'] = $obj;

        return view('templates.bootstrap.display', $data)->render();
    }

    public function btSelect($attrName, $values, $value, $numCols = 12, $required = true)
    {
        $data['numCols'] = $numCols;
        $data['attrName'] = $attrName;
        $data['params']['class'] = 'form-control';
        $data['attrValue'] = $value;
        $data['params']['id'] = $attrName;
        $data['options'] = $values;
        if ($required) {
            $data['params']['required'] = 'true';
        }
        $data['inputType'] = "select";

        return view('templates.bootstrap.input', $data)->render();
    }

    function simple2($object, $attrName, $numCols = 12, $type = 'text', $html = [], $options = [], $mostrarLabel = true)
    {
        $this->model = $object;

        return $this->simple($attrName, $numCols, $type, $html, $options, $mostrarLabel);
    }

    function simple($attrName, $numCols = 12, $type = 'text', $html = [], $options = [], $mostrarLabel = true)
    {
        $obj = $this->model;
        $data['params'] = $html;
        $cleanAttrName = str_replace('[]', '', $attrName);
        if (!isset($data['params']['class'])) {
            $data['params']['class'] = '';
        }
        if ($obj->isDecimalField($cleanAttrName)) {
            $data['params']['class'] .= 'decimal-format ';
            $data['params']['data-m-dec'] = $obj->getDecimalPositions();
        } else {
            if ($obj->isRelatedField($cleanAttrName) && $type == 'text') {
                $type = 'select';
                $options = $obj->getRelatedOptions($cleanAttrName);
                if (count($options) > 30) {
                    $data['params']['class'] = ' has-select2 ';
                }
            } else {
                if ($obj->isDateField($cleanAttrName) && $type == "text") {
                    $data['params']['class'] = 'jqueryDatePicker ';
                    $data['attrValue'] = $obj->getValueAt($cleanAttrName);
                    if (method_exists($data['attrValue'], 'format')) {
                        $data['attrValue'] = $data['attrValue']->format('d/m/Y');
                    }
                } else {
                    if ($obj->isBooleanField($cleanAttrName) && $type == "text") {
                        $type = 'boolean';
                    }
                }
            }
        }
        $data['attrLabel'] = $obj->getDescription($cleanAttrName);
        $data['numCols'] = $numCols;
        $data['attrName'] = $attrName;
        if (!isset($data['attrValue'])) {
            $data['attrValue'] = $obj->getValueAt($cleanAttrName, false);
        }
        $data['params']['id'] = str_replace('->', '_', $cleanAttrName);
        $data['params']['class'] .= 'form-control';
        if ($obj->isRequired($attrName)) {
            $data['params']['required'] = 'true';
        }
        $data['inputType'] = $type;
        $data['options'] = $options;
        if ($type == "multiselect") {
            unset($data['params']['required']);
            $data['params']['multiple'] = "";
            $data['params']['class'] .= " advanced-select";
            $arr = $obj->{$data['params']['id']};
            $data['attrValue'] = [];
            if (is_array($arr)) {
                foreach ($arr as $value) {
                    $data['attrValue'][] = $value->id;
                }
            }
            $data['params']['style'] = 'width: 100%;';
        }
        if ($type == "textarea") {
            $data['params']['rows'] = 4;
        }
        $data['mostrarLabel'] = $mostrarLabel;

        return view('templates.bootstrap.input', $data)->render();
    }

    function submitBt($btn_type = "btn-volver")
    {
        return view('templates.bootstrap.submit', ['btn_type' => $btn_type])->render();
    }

    public function multiselect($relation, $numCols = 12)
    {
        $related = $this->model->{$relation}()->getRelated();
        $data['options'] = call_user_func([get_class($related), 'getCombo']);
        unset($data['options']['']);
        $data['params']['multiple'] = 'multiple';
        $data['params']['class'] = 'advanced-select';
        $data['params']['id'] = $relation;
        $data['params']['style'] = 'width: 100%;';
        $data['attrName'] = $relation . '[]';
        $data['values'] = $this->model->{$relation}->lists('id')->all();
        $data['numCols'] = $numCols;
        $data['params']['data-placeholder'] = $this->model->getDescription($relation);

        return view('templates.bootstrap.multiselect', $data)->render();
    }

}
