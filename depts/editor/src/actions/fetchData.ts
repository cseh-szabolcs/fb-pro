import {createAsyncThunk} from "@reduxjs/toolkit";
import xhr from "app/xhr";

const DATA_PATH = `/${window.APP_LOCALE}/editor/${window.DATA_TYPE}/${window.DATA_ID}/data`;

export const fetchData = createAsyncThunk('fetchData', async () => {
  const response = await xhr.get(DATA_PATH);

  return await response.json() as ResponseData;
});

export interface FormData {
  title: string;
  description: string;
  uuid: string;
}

export interface ElementData {
  uuid: string;
  type: string;
  role?: string;
  position: number;
  children: ElementData[];
}

export interface ResponseData {
  created: string;
  document: ElementData;
  form: FormData;
  updated: string;
  uuid: string;
}
