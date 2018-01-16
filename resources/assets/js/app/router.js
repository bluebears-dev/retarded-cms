import userRoutes from "./routes/user"
import optionsRoutes from "./routes/options"
import pageRoutes from "./routes/page"
import mainRoutes from "./routes/main"
import menuRoutes from "./routes/menu"

let routes = mainRoutes
    .concat(userRoutes)
    .concat(optionsRoutes)
    .concat(pageRoutes)
    .concat(menuRoutes);

export default routes