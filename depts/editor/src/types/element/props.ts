export type Side<T = number|string> = {
  equal: boolean;
  top?: T;
  right?: T;
  bottom?: T;
  left?: T;
}

export type Corner<T = number|string> = {
  equal: boolean;
  topLeft?: T;
  topRight?: T;
  bottomRight?: T;
  bottomLeft?: T;
}
