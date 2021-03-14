import Home from "./components/Home";
import About from "./components/About";
import ConfirmationCode from "./components/ConfirmationCode";
import SocialBuisnessAccount from "./components/SocialBuisnessAccount";
import NavBar from "./components/NavBar";
import Post from "./components/Post";
import PlayGround from "./components/PlayGround";

export default {
    mode: "history",

    routes: [
        {
            path: "/",
            component: Home
        },
        {
            path: "/about",
            component: About
        },
        {
            name: "confirm",
            path: "/confirm",
            component: ConfirmationCode
        },
        {
            name: "playground",
            path: "/playground",
            component: PlayGround
        },
        {
            name: "account",
            path: "/account",
            component: SocialBuisnessAccount
        },
        {
            name: "nav",
            path: "/nav",
            component: NavBar
        },
        {
            name: "post",
            path: "/post",
            component: Post
        }
    ]
};
