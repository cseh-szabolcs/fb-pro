<?php

namespace App\Constants\Editor;

enum InputType: string
{
    case Checkbox = 'checkbox';
    case Color = 'color';
    case Date = 'date';
    case DateTime = 'datetime-local';
    case Email = 'email';
    case File = 'file';
    case Hidden = 'hidden';
    case Number = 'number';
    case Password = 'password';
    case Radio = 'radio';
    case Select = 'select';
    case Text = 'text';
    case Textarea = 'textarea';
    case Time = 'time';
    case Url = 'url';
}
