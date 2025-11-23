import {request} from './request';

export async function get(path: string) {
  return await request(path);
}
