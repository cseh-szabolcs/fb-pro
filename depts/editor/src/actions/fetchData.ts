import {createAsyncThunk} from "@reduxjs/toolkit";
import xhr from "app/xhr";

export const fetchData = createAsyncThunk('fetchData', async () => {
  const response = await xhr.get(window.DATA_SRC);

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
