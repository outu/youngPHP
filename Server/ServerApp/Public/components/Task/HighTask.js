import {API_CREATE_HIGH_TASK, API_GET_HIGH_TASK} from "../../public/api.js";


export default {
    name: 'NewTask',
    template: `
     <div class="build build-linux-client build-body">
        <div v-if="!!loading" class="loading">
            <img src="../../public/css/image/loading.gif" class="img-loading">
        </div>
        <div v-if="!loading" class="table">
            <el-table :data="list.slice((currentPage-1)*pagesize, currentPage*pagesize)" stripe stype="width: 100%">
                <el-table-column prop="id" label="序号" width="200%"></el-table-column>
                <el-table-column prop="name" label="商品名" show-overflow-tooltip></el-table-column>
                <el-table-column prop="size" label="价格"></el-table-column>
                <el-table-column prop="total" label="数量"></el-table-column>
                <el-table-column label="操作">
                    <template slot-scope="scope">
                        <button type="button" class="btn btn-primary" v-on:click="newTask(scope.row.id)">buy</button>
                    </template>
             
                </el-table-column>
            </el-table>
            <el-pagination
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                :current-page="currentPage"
                :page-sizes="[10, 20, 50, 100]"
                :page-size="pagesize"
                layout="total, sizes, prev, pager, next, jumper"
                :total="count">
            </el-pagination>
        </div>
        
        
        
        <div v-if="!!buildButtonDisabled" class="spinner-border text-primary mt-2" role="status"></div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                {{message}}
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
    </div>
    `,
    data(){
        return {
            message: '',
            list: '',
            count: 0,
            // 分页信息  当前页数，每页显示数据条数
            pagesize: 10,
            currentPage: 1,
            // tableHeader存放的是表头的内容
            // label:表头单元格内容  key:表头对应的字段名
            tableHeader: [
                { label: '商品名', key: 'name' },
                { label: '价格', key: 'size' },
                { label: '数量', key: 'total' },
            ],
            buildButtonDisabled: false,
            loading: true,
        }
    },
    mounted(){
        API_GET_HIGH_TASK({
            pagesize: this.pagesize,
            currentPage: this.currentPage,
        })
            .then((response) => {
                this.list = response.data.data.list;
                this.count = response.data.data.count;
                this.message = response.data.message;
                this.loading = false;
            })
            .catch((error) => {
                console.log("CATCH_1", error);
                this.message = error;
                $('#exampleModalCenter').modal();
                this.buildButtonDisabled = false;
                this.loading = false;
            });
    },
    methods: {
        newTask: function (nGoodId) {
            this.buildButtonDisabled = true;
            API_CREATE_HIGH_TASK({
                nGoodId:nGoodId
            })
                .then((response) => {

                    if (response.data.code === 200){
                        this.message = 'checkout success.';
                    } else {
                        this.message = 'The goods are sold out';
                    }
                    $('#exampleModalCenter').modal();
                    this.buildButtonDisabled = false;
                })
                .catch((error) => {
                    console.log("CATCH_1", error);
                    this.message = error;
                    $('#exampleModalCenter').modal();
                    this.buildButtonDisabled = false;
                });
        },
        handleSizeChange: function (size) {
            this.pagesize = size;
        },
        handleCurrentChange: function(currentPage){
            this.currentPage = currentPage;
        }
    }

};