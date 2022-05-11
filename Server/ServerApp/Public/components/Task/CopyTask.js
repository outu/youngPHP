import {API_CREATE_COPY_TASK} from "../../public/api.js";

export default {
    name: 'NewTask',
    template: `
    <div class="build build-linux-client">
        <form>
        <div class="form-row">
            <div class="form-group col-md-4">
              <label for="inputVersion">source directory</label>
              <input type="text" class="form-control" id="inputSourceDir" placeholder="Source directory to be copied" v-model="sourceDir">
            </div>
             <div class="form-group col-md-4">
              <label for="inputVersion">target directory</label>
              <input type="text" class="form-control" id="inputTargetDir" placeholder="Directory copied to" v-model="targetDir">
            </div>
             
          </div>
        </form>
        <div>
            <button type="button" class="btn btn-primary" v-on:click="newTask">create</button>
        </div>
        <div v-if="!!buildButtonDisabled" class="spinner-border text-primary mt-2" role="status"></div>
          <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">created info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                {{ message }}
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
    `,
    data(){
        return {
            message: '',
            sourceDir: '',
            targetDir: '',
            buildButtonDisabled: false,
        }
    },

    methods: {
        newTask: function () {
            this.buildButtonDisabled = true;
            API_CREATE_COPY_TASK({
                sSourceDir: this.sourceDir,
                sTargetDir: this.targetDir,
            })
                .then((response) => {
                    console.log("THEN_1", response);
                    this.message = response.data.data + " task has been added this time";
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
    }

};