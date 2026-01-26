import type {Side} from "app/types/element/props.ts";
import type {CSSProperties} from "react";

export class SideModel<T = number|string> {
  public readonly equal: boolean;
  private readonly left?: T;
  private readonly right?: T;
  private readonly top?: T;
  private readonly bottom?: T;
  
  constructor(data?: Side<T>) {
    this.equal = data?.equal ?? true;
    this.left = data?.left;
    this.right = data?.right;
    this.top = data?.top;
    this.bottom = data?.bottom;
  }
  
  public getTop(defaultValue?: T) {
    return this.top || defaultValue;
  }

  public getRight(defaultValue?: T) {
    return this.equal
      ? this.getTop(defaultValue)
      : this.right || defaultValue;
  }

  public getBottom(defaultValue?: T) {
    return this.equal
      ? this.getTop(defaultValue)
      : this.bottom || defaultValue;
  }

  public getLeft(defaultValue?: T) {
    return this.equal
      ? this.getTop(defaultValue)
      : this.left || defaultValue;
  }

  public toCssPadding(defaultValue?: T): CSSProperties {
    return {
      paddingLeft: this.getLeft(defaultValue) as number,
      paddingRight: this.getRight(defaultValue) as number,
      paddingTop: this.getTop(defaultValue) as number,
      paddingBottom: this.getBottom(defaultValue) as number,
    };
  }

  public isEmpty(): boolean {
    return !this.left && !this.right && !this.bottom && !this.top;
  }
}
