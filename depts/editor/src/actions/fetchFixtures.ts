import {createAsyncThunk} from "@reduxjs/toolkit";
import xhr from "app/xhr";
import type {ResponseElement} from "app/types/element.ts";

const FIXTURES_PATH = `/${window.APP_LOCALE}/editor/fixtures/${window.DATA_TYPE}`;

export const fetchFixtures = createAsyncThunk('fetchFixtures', async () => {
  const response = await xhr.get(FIXTURES_PATH);

  return {
    uuid: 'root',
    children: await response.json(),
  } as unknown as ResponseElement;
});
