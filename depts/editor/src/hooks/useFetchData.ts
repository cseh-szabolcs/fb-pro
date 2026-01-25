import {useAppDispatch} from "app/store";
import {useEffect} from "react";
import {fetchData} from "app/actions/fetchData.ts";
import {fetchFixtures} from "app/actions/fetchFixtures.ts";

export function useFetchData() {
  const dispatch = useAppDispatch();

  useEffect(() => {
    if (!initialized) {
      dispatch(fetchData());
      dispatch(fetchFixtures());
      initialized = true;
    }
  }, [dispatch]);
}

let initialized = false;
