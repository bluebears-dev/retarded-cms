import user_routes from "./routes/user"
import options_routes from "./routes/options"
import page_routes from "./routes/page"
import main_routes from "./routes/main"

let routes = main_routes
    .concat(user_routes)
    .concat(options_routes)
    .concat(page_routes);

export default routes