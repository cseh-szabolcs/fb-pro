import type {Input} from "app/types/element.ts";

export function DefaultInput({inputType, label, id, name, value, placeholder}: Input) {

  return (
    <div>
      <label htmlFor={id} className="form-label">
        {label}
      </label>
      <input
        type={inputType}
        className="form-control"
        id={id}
        name={name}
        value={value ? value : ''}
        placeholder={placeholder}
        readOnly={true}
      />
    </div>
  );
}
