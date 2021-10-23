<template>
  <div class="row">

        <div class="col-md-12 col-xl-12 col-sm-12 ">
      
            <button class="btn btn-success m-4" @click="add()">Add Campaign <i class="fas fa-plus-circle"></i></button>
        </div>
        <div class="row">
      <div
        v-if="status_msg"
        :class="{ 'alert-success': status, 'alert-danger': !status }"
        class="alert"
        role="alert"
      >
        {{ status_msg }}
      </div>
        </div>
        <div class="col-md-12 col-xl-12 col-sm-12 ">
            <div class="card">
                <div class="card-header">
                    <h4>All Campaigns</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Total Budget($)</th>
                                    <th>Daily Budget($)</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody v-if="campaigns.length > 0">
                                <tr v-for="(c,key) in campaigns" :key="key">
                                    <td>{{ key+1 }}</td>
                                    <td>{{ c.name }}</td>
                                    <td>{{ c.total_budget }}</td>
                                    <td>{{ c.daily_budget }}</td>
                                    <td>{{c.date_from}}</td>
                                    <td>{{c.date_to}}</td>
                                    <td>
                                      <button class="btn btn-success m-2" @click="edit(key)"><i class="fas fa-edit"></i></button>
                                        <button type="button" @click="deleteCampaign(c.id)" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                        <button class="btn btn-success m-2" @click="viewPost(key)"><i class="fas fa-eye"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                <td></td>
                                    <td colspan="6" align="center">No Campaigns Found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    





    <!-- <div class="col-md-6" v-for="(c, i) in campaigns" :key=i>
      <div class="card mt-4">
        <img v-if="c.campaigns_images.length" class="card-img-top" :src="c.campaigns_images[0].campaign_image_path">
        <div class="card-body">
          <p class="card-text"><strong>{{ c.name }}</strong>
          </p>
          
        </div>
        <button class="btn btn-success m-2" @click="viewPost(i)">View Campaign</button>
      </div>
    </div> -->


    
    <el-dialog v-if="currentCampaign" :visible.sync="DialogVisible" width="40%">
      <span>
        <h3>{{ currentCampaign.name }}</h3>
        <div class="row">
          <div class="col-md-6" v-for="(img, i) in currentCampaign.campaigns_images" :key=i>
            <img :src="img.campaign_image_path" class="img-thumbnail" alt="">
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
        <p class="card-text"><strong>Campaign: {{ currentCampaign.name }}</strong></p>
        </div>
        </div>
        <p class="card-text"><strong>Daily Budget: $ {{ currentCampaign.daily_budget }}</strong> </p>
        <p class="card-text"><strong>Total Budget: $ {{ currentCampaign.total_budget }}</strong></p>
        <p class="card-text"><strong>From: {{ currentCampaign.date_from }}</strong> </p>
        <p class="card-text"><strong> To : {{ currentCampaign.date_to }}</strong></p>
      </span>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="DialogVisible = false">Ok</el-button>
      </span>
    </el-dialog>


       <el-dialog  :visible.sync="AddDialogVisible" width="50%">
      <div :key="componentKey" class="card mt-4">
    <div class="card-header">
      New Campaign
    </div>
    <div class="card-body">
  
      <form>
        <div class="form-group">
          <label for="exampleFormControlInput1">Name </label>
          <input
            id="name"
            v-model="name"
            type="text"
            class="form-control"
            placeholder="Campaign Name"
            required
          >
        </div>

          <div class="form-group">
          <label for="exampleFormControlInput1">Daily Budget </label>
          <input
            id="daily"
            v-model="daily"
            type="number"
            class="form-control"
            placeholder="Daily Budget"
            required
          >
        </div>

          <div class="form-group">
          <label for="exampleFormControlInput1">Total Budget </label>
          <input
            id="total"
            v-model="total"
            type="number"
            class="form-control"
            placeholder="Total Budget"
            required
          >
        </div>

          <div class="form-group">
          <label for="exampleFormControlInput1">From </label>
          <input
            id="from"
            v-model="from"
            type="date"
            class="form-control"
            placeholder="From"
            required
          >
        </div>

          <div class="form-group">
          <label for="exampleFormControlInput1">To </label>
          <input
            id="to"
            v-model="to"
            type="date"
            class="form-control"
            placeholder="To"
            required
          >
        </div>
   
        <div class>
          <el-upload
            action="https://jsonplaceholder.typicode.com/posts/"
            list-type="picture-card"
            :on-preview="handlePictureCardPreview"
            :on-change="updateImageList"
            :auto-upload="false"
          >
           <i class="fas fa-plus-circle"></i>
          </el-upload>
          <el-dialog :visible.sync="dialogVisible">
            <img width="100%" :src="dialogImageUrl" alt>
          </el-dialog>
        </div>
      </form>
    </div>
    <div class="card-footer">
      <button
        type="button"
        class="btn btn-success"
        @click="create"
      >
        {{ isCreating ? "Creating..." : "Create Campaign" }}
      </button>
    </div>
  </div>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="AddDialogVisible = false">Close</el-button>
      </span>
    </el-dialog>

      <el-dialog v-if="campaign" :visible.sync="EditDialogVisible" width="50%">

    <div  class="card mt-4">
    <div class="card-header">
      Update Campaign
    </div>
    <div class="card-body">
  
      <form>
        <div class="form-group">
          <label for="exampleFormControlInput1">Name </label>
          <input
            id="name"
            v-model="campaign.name"
            type="text"
            class="form-control"
            placeholder="Campaign Name"
            required
          >
        </div>

          <div class="form-group">
          <label for="exampleFormControlInput1">Daily Budget </label>
          <input
            id="daily"
            v-model="campaign.daily_budget"
            type="number"
            class="form-control"
            placeholder="Daily Budget"
            required
          >
        </div>

          <div class="form-group">
          <label for="exampleFormControlInput1">Total Budget </label>
          <input
            id="total"
            v-model="campaign.total_budget"
            type="number"
            class="form-control"
            placeholder="Total Budget"
            required
          >
        </div>

          <div class="form-group">
          <label for="exampleFormControlInput1">From </label>
          <input
            id="from"
            v-model="campaign.date_from"
            type="date"
            class="form-control"
            placeholder="From"
            required
          >
        </div>

          <div class="form-group">
          <label for="exampleFormControlInput1">To </label>
          <input
            id="to"
            v-model="campaign.date_to"
            type="date"
            class="form-control"
            placeholder="To"
            required
          >
        </div>
   
        <div class>
          <el-upload
            
            list-type="picture-card"
            :on-preview="handlePictureCardPreview"
            :on-change="updateImageList"
            :auto-upload="false"
          >
            <i class="fas fa-plus-circle"></i>
          </el-upload>
          <el-dialog :visible.sync="dialogVisible">
            <img width="100%" :src="dialogImageUrl" alt>
          </el-dialog>
        </div>
      </form>
    </div>
    <div class="card-footer">
      <button
        type="button"
        class="btn btn-success"
        @click="update"
      >
        {{ isUpdating ? "Updating..." : "Update Campaign" }}
      </button>
    </div>
  </div>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="EditDialogVisible = false">Close</el-button>
      </span>





      <!-- <span>
        <h3>{{ currentCampaign.name }}</h3>
        <div class="row">
          <div class="col-md-6" v-for="(img, i) in currentCampaign.campaigns_images" :key=i>
            <img :src="img.campaign_image_path" class="img-thumbnail" alt="">
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
        <p class="card-text"><strong>Campaign: {{ currentCampaign.name }}</strong></p>
        </div>
        </div>
        <p class="card-text"><strong>Daily Budget: $ {{ currentCampaign.daily_budget }}</strong> </p>
        <p class="card-text"><strong>Total Budget: $ {{ currentCampaign.total_budget }}</strong></p>
        <p class="card-text"><strong>From: {{ currentCampaign.date_from }}</strong> </p>
        <p class="card-text"><strong> To : {{ currentCampaign.date_to }}</strong></p>
      </span>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="AddDialogVisible = false">Ok</el-button>
      </span> -->
    </el-dialog>
  </div>
</template>



<style>
.avatar-uploader .el-upload {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.avatar-uploader .el-upload:hover {
  border-color: #409eff;
}
.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 178px;
  height: 178px;
  line-height: 178px;
  text-align: center;
}
.avatar {
  width: 178px;
  height: 178px;
  display: block;
}
</style>
<script>
import { mapState,mapActions } from 'vuex';

export default {
  name: 'all-campaigns',
  data() {
    return {
      DialogVisible: false,
      AddDialogVisible: false,
      EditDialogVisible: false,
      dialogVisible: false,
      currentCampaign: '',
      dialogImageUrl: '',
      imageList: [],
      status_msg: '',
      status: '',
      isCreating: false,
      isUpdating: false,
      name: '',
      daily: '',
      total: '',
      from: '',
      to: '',
      componentKey: 0,
      campaign:{}

    };
  },
  computed: {
    ...mapState(['campaigns'])
  },
  beforeMount() {
    this.$store.dispatch('getAll');
  },
  methods: {
     ...mapActions(['getAll']),
      updateImageList (file) {
      this.imageList.push(file.raw)
    },
    handlePictureCardPreview (file) {
      this.dialogImageUrl = file.url
      this.imageList.push(file)
      this.dialogVisible = true
    },
     create (e) {
      e.preventDefault()
      if (!this.validateForm()) {
        return false
      }
      const that = this
      this.isCreating = true
      const formData = new FormData()
      formData.append('name', this.name)
      formData.append('daily', this.daily)
      formData.append('total', this.total)
      formData.append('from', this.from)
      formData.append('to', this.to)
    
      $.each(this.imageList, function (key, image) {
        formData.append(`images[${key}]`, image)
      })
      api
        .post('api/campaigns', formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        })
        .then((res) => {
          this.name = this.daily = ''
          this.status = true
          this.showNotification('Campaign  Created')
          this.isCreating = false
          this.imageList = []
          that.getAll()
          that.componentKey += 1
        })
    },
      update () {
      //console.log(this.campaign.date_to,this.campaign.name,this.campaign.date_from,this.campaign.daily_budget);

      const that = this
      this.isUpdating = true
      const formData = new FormData()
      formData.append('name', this.campaign.name)
      formData.append('daily', this.campaign.daily_budget)
      formData.append('total', this.campaign.total_budget)
      formData.append('from', this.campaign.date_from)
      formData.append('to', this.campaign.date_to)
    
      $.each(this.imageList, function (key, image) {
        formData.append(`images[${key}]`, image)
      })
      api
        .patch('api/campaigns/'+this.campaign.id, formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        })
        .then((res) => {
          this.campaign = {}
          this.status = true
          this.showNotification('Campaign  Updated')
          this.isUpdating = false
          this.imageList = []
          that.getAll()
          that.componentKey += 1
        })
    },
    validateForm () {
      // no vaildation for images - it is needed
      if (!this.name) {
        this.status = false
        this.showNotification('Campaign name cannot be empty')
        return false
      }
       if (!this.daily) {
        this.status = false
        this.showNotification('Budget Daily spending cannot be empty')
        return false
      }
       if (!this.total) {
        this.status = false
        this.showNotification('Budget Total cannot be empty')
        return false
      }
      
      if (!this.from) {
        this.status = false
        this.showNotification('Date From cannot be empty')
        return false
      }
        if (!this.to) {
        this.status = false
        this.showNotification('Date To cannot be empty')
        return false
      }
      return true
    },
    showNotification (message) {
      this.status_msg = message
      setTimeout(() => {
        this.status_msg = ''
      }, 3000)
    },

     deleteCampaign(id){
            if(confirm("Are you sure to delete this campaign ?")){
                api.get(`api/campaigns/${id}`).then(response=>{
                    this.getAll()
                }).catch(error=>{
                    console.log(error)
                })
            }
        },
    viewPost(index) {
      const campaign = this.campaigns[index];
      this.currentCampaign = campaign;
      this.DialogVisible = true;
    },
     add(index) {
      this.AddDialogVisible = true;
    },
     edit(index) {
      const campaign = this.campaigns[index];
      this.campaign = campaign;
      this.EditDialogVisible = true;
    }
  },
}
</script>