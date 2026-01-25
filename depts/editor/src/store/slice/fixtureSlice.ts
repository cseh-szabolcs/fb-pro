import {createEntityAdapter, createSlice, type PayloadAction,} from "@reduxjs/toolkit";
import {fetchFixtures, type FixturesData} from "app/actions/fetchFixtures.ts";
import type {Element} from "app/types/element.ts";

const elementAdapter = createEntityAdapter<Element, string>({
  selectId: (element) => element.uuid,
});

const elementSelector = elementAdapter.getSelectors();

export const FixtureSlice = createSlice({
  name: 'fixtures',
  initialState: elementAdapter.getInitialState(),
  reducers: {
    addElement: elementAdapter.addOne,
    updateElement: (state, action: PayloadAction<{
      uuid: string;
      changes: Partial<Element>;
    }>) => {
      elementAdapter.updateOne(state, { id: action.payload.uuid, changes: action.payload.changes });
    },
    removeElement: elementAdapter.removeOne,
  },
  extraReducers: (builder) => {
    builder.addCase(fetchFixtures.fulfilled, (state, {payload}) => {
      const normalized = normalizeElements(payload, {});
      for (const [, element] of Object.entries(normalized)) {
        elementAdapter.upsertOne(state, element);
      }
    });
  },
  selectors: {
    selectAll: elementSelector.selectAll,
    selectById: elementSelector.selectById,
    selectIds: elementSelector.selectIds,
    selectEntities: elementSelector.selectEntities,
    selectTotal: elementSelector.selectTotal,
  },
});

function normalizeElements(current: FixturesData, state: Record<string, Element>) {
  state[current.uuid] = {
    ...current,
    children: current.children.map(child => child.uuid),
  }

  for (const child of current.children) {
    normalizeElements(child, state);
  }

  return state;
}

export const {
  selectAll,
  selectById,
  selectIds,
  selectEntities,
  selectTotal,
} = FixtureSlice.selectors;
