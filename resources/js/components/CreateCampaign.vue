<template>
  <div :key="componentKey" class="card mt-4">
    <div class="card-header">
      New Campaign
    </div>
    <div class="card-body">
      <div
        v-if="status_msg"
        :class="{ 'alert-success': status, 'alert-danger': !status }"
        class="alert"
        role="alert"
      >
        {{ status_msg }}
      </div>
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
            <i class="el-icon-plus" />
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
        @click="createPost"
      >
        {{ isCreatingPost ? "Creating..." : "Create Campaign" }}
      </button>
    </div>
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
import { mapActions } from 'vuex'
export default {
  name: 'CreatePost',
  data () {
    return {
      dialogImageUrl: '',
      dialogVisible: false,
      imageList: [],
      status_msg: '',
      status: '',
      isCreatingPost: false,
      name: '',
      daily: '',
      total: '',
      from: '',
      to: '',
      //daily: '',
      componentKey: 0
    }
  },
  computed: {},
  mounted () {},
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
    createPost (e) {
      e.preventDefault()
      if (!this.validateForm()) {
        return false
      }
      const that = this
      this.isCreatingPost = true
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
        .post('create', formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        })
        .then((res) => {
          this.name = this.daily = ''
          this.status = true
          this.showNotification('Campaign  Created')
          this.isCreatingPost = false
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
    }
  }
}
</script>
