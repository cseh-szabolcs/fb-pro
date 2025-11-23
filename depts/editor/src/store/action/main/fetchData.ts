import {createAsyncThunk} from "@reduxjs/toolkit";
import xhr from "app/xhr";
import {useAppDispatch} from "app/store";
import {useEffect} from "react";

export const fetchData = createAsyncThunk('fetchData', async () => {
  const response = await xhr.get(window.DATA_SRC);

  return await response.json();
});

export function useFetchData() {
  const dispatch = useAppDispatch();

  useEffect(() => {
    dispatch(fetchData());
  }, [dispatch]);
}
