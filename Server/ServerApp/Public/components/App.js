export default {
    name: 'App',
    template: `
    <div class="app">
        <div class="header">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand" href="#">tool</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item" v-for="(item, index) in builderLinkNameList"  @click="select_li(index)" :class="{active:selectLi==index}">
                            <router-link :to="{path:item.path}" class="nav-link">{{item.buildLinkName}}</router-link>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="main container-fluid" style="padding-top: 30px">
             <router-view></router-view>
        </div>
    </div>
  `,
    data(){
        this.$router.push('/CopyTask');
        return {
            builderLinkNameList:[
                {buildLinkName: "Copy Task", path: "/CopyTask"},
                {buildLinkName: "High Concurrency Task", path: "/HighTask"},
                {buildLinkName: "Monitor Task", path: "/MonitorTask"},
                {buildLinkName: "Completed Task", path: "/CompletedTask"}
            ],
            selectLi: 0,
        }
    },
    methods: {
        select_li(index){
            this.selectLi = index;
        }
    }
};