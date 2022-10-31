<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Task;

class TooManyTasksRule implements Rule
{

  protected $request_data;
  protected $count;
  /**
  * Create a new rule instance.
  *
  * @return void
  */
  public function __construct($request_data)
  {
    $this->request_data = $request_data;
  }

  /**
  * Determine if the validation rule passes.
  *
  * @param  string  $attribute
  * @param  mixed  $value
  * @return bool
  */
  public function passes($attribute, $value)
  {
    $req = $this->request_data;

    $tasks = Task::where('finish_at', '>', $req['start_at'])->where('start_at', '<', $req['finish_at'])->get()->count();

    $this->count = $tasks;

    if ( $tasks > 4 ) {
      return false;
    }
    
    return true;
  }

  /**
  * Get the validation error message.
  *
  * @return string
  */
  public function message()
  {
    return 'Слишком много ('. $this->count .') задач в указанном временном интервале.';
  }
}
