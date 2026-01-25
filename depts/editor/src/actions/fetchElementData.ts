import {createAsyncThunk} from "@reduxjs/toolkit";
import xhr from "app/xhr";
import type {ResponseElement} from "app/types/element.ts";
import type {FormData} from "app/types/form.ts";

const DATA_PATH = `/${window.APP_LOCALE}/editor/${window.DATA_TYPE}/${window.DATA_ID}/data`;

export const fetchElementData = createAsyncThunk('fetchData', async () => {
  const response = await xhr.get(DATA_PATH);

  return await response.json() as {
    created: string;
    document: ResponseElement;
    form: FormData;
    updated: string;
    uuid: string;
  };
});
