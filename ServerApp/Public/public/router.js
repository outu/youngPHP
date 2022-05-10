import Overview from '../components/Overview.js'
import CopyTask from '../components/Task/CopyTask.js'
import HighTask from '../components/Task/HighTask.js'
import CompletedTask from '../components/Task/CompletedTask.js'
import MonitorTask from "../components/Task/MonitorTask.js"

const routes = [
    { path: '/', component: Overview},
    { path: '/CopyTask', component: CopyTask },
    { path: '/HighTask', component: HighTask },
    { path: '/MonitorTask', component: MonitorTask },
    { path: '/CompletedTask', component: CompletedTask },
];

const router = new VueRouter({
    routes // short for `routes: routes`
});

export default router;