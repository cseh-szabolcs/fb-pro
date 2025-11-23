import {useAppDispatch} from "app/store";
import {useEffect} from "react";
import {fetchData} from "app/actions/fetchData.ts";

export function useFetchData() {
  const dispatch = useAppDispatch();

  useEffect(() => {
    dispatch(fetchData());
  }, [dispatch]);
}
