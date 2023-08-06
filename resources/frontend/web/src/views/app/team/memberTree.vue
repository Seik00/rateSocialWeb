<template>
  <div class="main-content">
    <div class="appBar">
      <a @click="$router.go(-1)">
        <img src="../../../assets/images/digital/right.svg" alt="">
      </a>
      <span>{{ $t("my_team") }}</span>
      <b-button v-if="isChild" @click="backToTop" variant="primary-outline" class="right-side">
        {{ $t("top") }}
      </b-button>
    </div>
    <div class="p-2">
      <div v-if="!isLoading && testData.length == 0" style="
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
          ">
        <p>No Data</p>
      </div>
      <div v-else-if="isLoading" style="
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
          ">
        <p>{{ $t("loading...") }}</p>
      </div>
      <div v-if="isLoading" style="
                    position: absolute;
                    height: 100%;
                    width: 100%;
                    z-index: 3;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                  ">
        <span style="
                      background-color: #c0dfff;
                      color: #409eff;
                      padding: 7px 30px;
                      border-radius: 3px;
                    ">{{ $t("loading...") }}</span>
      </div>
      <div class="bg-greyblue p-2 mb-2" style="border-radius: 10px" v-for="item in testData" :key="item.id">
        <!-- <b-row>
        <b-col md="12">
          <b-card style="">
            <v-jstree
              :data="asyncData"
              multiple
              allow-batch
              whole-row
              :async="loadData"
              ref="tree"
            ></v-jstree>
          </b-card>
        </b-col>
      </b-row> -->
        <b-row @click="openChild(item)" align-v="center" align-h="between">
          <b-col cols="6">
            <p class="mb-1 text-white">{{ item.username }}</p>
            <!-- <span>{{ item.updated_at }}</span> -->
          </b-col>
          <b-col cols="6">
            <span class="text-right d-block">{{ $i18n.locale == "en" ? item.package_en : item.package }}</span>
          </b-col>
          <b-col cols="6">
            <p class="mb-1 text-muted">{{ $t("sponsor_amount") }}</p>
          </b-col>
          <b-col cols="5">
            <span class="text-white text-right d-block">{{ item.total_sponsor }}</span>
          </b-col>
          <b-col cols="6">
            <p class="mb-1 text-muted">{{ $t("team") }}</p>
          </b-col>
          <b-col cols="5">
            <span class="text-white text-right d-block">{{ item.team }}</span>
          </b-col>
          <b-col cols="6">
            <p class="mb-1 text-muted">{{ $t("active_amount") }}</p>
          </b-col>
          <b-col cols="5">
            <span class="text-white text-right d-block">{{ item.active }}</span>
          </b-col>
          <!-- <b-col cols="7">
            <b-row>
              <b-col cols="4">
                <div class="mx-auto">
                  <img class="" :src="item.package_icon" @error="imageLoadError" height="45px" width="auto" />
                </div>
              </b-col>
              <b-col cols="8">
                <h4 class="mb-0" style="
                              white-space: nowrap;
                              overflow: hidden;
                              text-overflow: ellipsis;
                            ">
                  {{ item.username }}
                </h4>
                <p>
                  {{ $i18n.locale == "en" ? item.package_en : item.package }}
                </p>
              </b-col>
            </b-row>
          </b-col>
          <b-col cols="5">
            <b-row class="text-14 font-weight-bold mx-0">
              <b-col cols="8" class="px-0">
                <p class="mb-0">{{ $t("sponsor_amount") }}</p>
              </b-col>
              <b-col class="px-0"><span class="text-success">{{
                item.total_sponsor
              }}</span></b-col>
            </b-row>
            <b-row class="text-14 font-weight-bold mx-0">
              <b-col class="px-0" cols="8">
                <p class="mb-0">{{ $t("team") }}:</p>
              </b-col>
              <b-col class="px-0"><span class="text-success">{{ item.team }}</span></b-col>
            </b-row>
            <b-row class="text-14 font-weight-bold mx-0">
              <b-col cols="8" class="px-0">
                <p class="mb-0">{{ $t("active_amount") }}</p>
              </b-col>
              <b-col class="px-0"><span class="text-success">{{ item.active }}</span></b-col>
            </b-row>
          </b-col> -->
        </b-row>
      </div>
    </div>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getMemberTree } from "../../../system/api/api";
import Dialog from "../../../components/dialog.vue";
import { handleError } from "../../../system/handleRes";
import { mapGetters } from "vuex";
// import VJstree from "vue-jstree";
export default {
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
    // VJstree,
  },
  data() {
    return {
      username: "",
      editingItem: {},
      editingNode: null,
      canClear: false,
      isChild: false,
      parent: null,
      uid: "",
      asyncData: [],
      testData: [],
      isLoading: true,
      userIcon: require("../../../assets/images/faces/user.png"),
    };
  },
  methods: {
    imageLoadError(event) {
      event.target.src = this.userIcon;
    },
    openChild(item) {
      if (item.team > 0) {
        this.loadItems(item.id);
        this.testData = [];
        this.testData.push(item);
        this.isChild = true;
      } else {
        this.$refs.msg.makeToast("warning", this.$t("no_team"));
      }
    },
    backToTop() {
      this.isChild = false;
      this.testData = [];
      this.loadItems(null);
    },
    loadData: async function (oriNode, resolve) {
      var data;

      if (oriNode.data.id) {
        data = await this.loadItems(oriNode.data.id);
      } else {
        data = await this.loadItems(null);
      }

      if (data) {
        resolve(data);
      }
    },

    async loadItems(parent) {
      var userID = parent == null ? encodeURIComponent("#") : parent;
      var result = getMemberTree(userID);
      var self = this;
      this.isLoading = true;
      var returnData;
      returnData = await result
        .then(async function (value) {
          // var tmpData = [];
          var returnData = value.data.data;
          for (let i = 0; i < returnData.length; i++) {
            // var tmap = {};
            // tmap["id"] = returnData[i]["id"];
            // tmap["text"] = self.processText(returnData[i]);
            // tmap["icon"] = "fa fa-user";
            // tmap["isLeaf"] = returnData[i]["team"] > 0 ? false : true;
            // tmpData.push(tmap);
            self.testData.push(returnData[i]);
          }
          self.isLoading = false;

          return self.testData;
        })
        .catch(function (error) {
          self.isLoading = false;
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
      return returnData;
    },

    processText(info) {
      var name = info["username"] + "-";
      var member =
        this.$i18n.locale == "en" ? info["package_en"] : info["package"];
      var sale =
        info["sales"] != null ? "(Sales:" + info["sales"] + ")" : "(Sales:)";
      var total = "(Total:" + info["total_sponsor"] + ")";
      var active = "(Active:" + info["active"] + ")";

      var text = name + member + sale + total + active;

      return text;
    },
  },
  created() {
    this.loadItems(null);
  },
  watch: {},
};
</script>

<style>
.hiddenClass {
  pointer-events: none;
  display: none;
}

.no_checkbox>i.tree-checkbox {
  display: none;
}

.bodyWidth {
  min-width: 120px;
}

.dateWidth {
  min-width: 100px;
}
</style>