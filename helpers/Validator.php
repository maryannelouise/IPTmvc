<?php
namespace App\Helpers;

use App\Models\Rooms;

class Validator
{
    protected $rules = [];
    protected $errors = [];

    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    public function validate()
    {
        $this->errors = [];  // Clear previous errors

        foreach ($this->rules as $field => $fieldRules) {
            foreach ($fieldRules as $rule => $ruleValue) {
                $fieldValue = isset($this->attributes[$field]) ? $this->attributes[$field] : null;

                // Apply the validation rule
                if (!$this->applyRule($field, $fieldValue, $rule, $ruleValue)) {
                    $this->errors[$field][] = $this->getErrorMessage($rule, $field, $ruleValue);
                }
            }
        }

        return empty($this->errors);  // Return true if no errors, false otherwise
    }

    // Apply validation rule for a specific field
    protected function applyRule($field, $value, $rule, $ruleValue)
    {
        switch ($rule) {
            case 'required':
                return !empty($value);
            case 'email':
                return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
            case 'minLength':
                return strlen($value) >= $ruleValue;
            case 'maxLength':
                return strlen($value) <= $ruleValue;
            case 'numeric':
                return is_numeric($value);
            case 'minValue':
                return $value >= $ruleValue;
            case 'maxValue':
                return $value <= $ruleValue;
            case 'confirmPassword':  // Dynamic rule for password confirmation
                // Check if password matches confirm password
                return $value === $this->attributes['password'];
            case 'unique':
                // Use isUnique to check if the field value is unique in the database
                return $this->isUnique($field, $value);
            default:
                return true;
        }
    }

    protected function getErrorMessage($rule, $field, $ruleValue = null)
    {
        $field = ucfirst(htmlspecialchars($field, ENT_QUOTES, 'UTF-8'));
        switch ($rule) {
            case 'required':
                return "{$field} is required.";
            case 'email':
                return "{$field} must be a valid email address.";
            case 'minLength':
                return "{$field} must be at least {$ruleValue} characters long.";
            case 'maxLength':
                return "{$field} must be at most {$ruleValue} characters long.";
            case 'numeric':
                return "{$field} must be a numeric value.";
            case 'minValue':
                return "{$field} must be greater than or equal to {$ruleValue}.";
            case 'maxValue':
                return "{$field} must be less than or equal to {$ruleValue}.";
            case "confirmPassword":
                return "Confirm Password did not match.";
            case "unique":
                return "{$field} already taken.";
            default:
                return "Invalid value for {$field}.";
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected function isUnique($field, $value)
    {
        // Assuming you have a method that can search for any field in the database
        $user = self::findByField($field, $value);
        return $user === false; // Return true if no record is found with the same value
    }



}
?>