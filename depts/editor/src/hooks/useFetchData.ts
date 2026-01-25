import {useAppDispatch} from "app/store";
import {useEffect} from "react";
import {fetchElementData} from "app/actions/fetchElementData.ts";
import {fetchFixtures} from "app/actions/fetchFixtures.ts";

export function useFetchData() {
  const dispatch = useAppDispatch();

  useEffect(() => {
    if (!initialized) {
      dispatch(fetchElementData());
      dispatch(fetchFixtures());
      initialized = true;
    }
  }, [dispatch]);
}

let initialized = false;
