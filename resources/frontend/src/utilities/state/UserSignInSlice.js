import {createSlice} from "@reduxjs/toolkit";

export const userSignInSlice = createSlice({
    name: 'authUser',
    initialState: {
        auth: {}
    },
    reducers: {
        storeAuthUser: (state, action) => {
            state.auth = action.payload
        }
    }
})

export const {storeAuthUser} = userSignInSlice.actions

export default userSignInSlice.reducer
