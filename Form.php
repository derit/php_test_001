<?php
/**
 * coded by Derit Agustin (derit.agustin@gmail.com) +62823 8852 7106.
 */
class Validation
{
    public function __construct($rules = [], $data)
    {
        $this->rules = $rules;
        $this->data = $data;
        $this->errors = [];
    }

    public function validate()
    {
        foreach ($this->rules as $key => $value) {
            $this->isValid($value, $key);
        }

        return empty($this->errors);
    }

    private function RulesCheck($rule, $field, $value)
    {
        switch ($rule) {
            case 'email':
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $this->errors[] = sprintf('%s Tidak Valid', $field);
            }
                break;
                case 'required':
                   if (empty($value)) {
                       $this->errors[] = sprintf('%s Tidak boleh kosong', $field);
                   }
                    break;
                    case substr($rule, 0, 3) === 'min':

                        $min = (int)substr($rule, 3, 3);
						 if (empty($value)) {
						     $this->errors[] = sprintf('%s Minimum %d', $field, $min);
						 } elseif (strlen($value) < $min) {
						        $this->errors[] = sprintf('%s Minimum %d', $field, $min);
						    }

                        break;
                case substr($rule, 0, 3) === 'max':
                        $max = (int)substr($rule, 3, 3);

					 if (empty($value)) {
					     $this->errors[] = sprintf('%s Minimum %d', $field, $max);
					 } elseif (strlen($value) > $max) {
					         $this->errors[] = sprintf('%s Minimum %d', $field, $max);
					     }
					 }

                        break;
            default:
                break;
        }
    }

    private function isValid($rules, $field)
    {
        $rules = explode(',', $rules);

        $value = isset($this->data[$field]) ? $this->data[$field] : '';

        foreach ($rules as $key => $rule) { 

            $this->RulesCheck(trim($rule), $field, $value);
        }
    }
}

class Form
{
    public function run($data, $validation, $res)
    {
        $Validator = new Validation($validation, $data);

        if ($Validator->validate()) {
            $res(0, '',$data);
        } else {
            $res(1, $Validator->errors, []);
        }
    }

    public function response($code, $message, $data)
    {
        echo json_encode(['error' => $code, 'message' => $message, 'details' => $data]);
    }
}
