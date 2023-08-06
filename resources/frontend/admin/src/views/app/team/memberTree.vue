<template>
  <div class="main-content">
    <breadcumb :page="$t('memberTree')" :folder="$t('userManage')" />
    <b-row>
      <b-col md="12">
        <b-card class="mb-30">
          <b-row align-v="center">
            <b-col md="2">
              <b-form-group
                id="input-group-1"
                :label="$t('username')"
                label-for="input-1"
              >
                <b-form-input
                  id="input-1"
                  type="text"
                  required
                  :placeholder="$t('Enter') + $t('username')"
                  v-model="username"
                ></b-form-input>
              </b-form-group>
            </b-col>

            <b-col md="1" class="mt-3 mt-md-0">
              <b-button variant="primary" @click="onSearch">{{
                $t("search")
              }}</b-button>
            </b-col>
            <b-col md="1" class="mt-3 mt-md-0" v-if="canClear">
              <b-button variant="danger" @click="onCancel">{{
                $t("clear")
              }}</b-button>
            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>

    <b-row>
      <b-col md="12">
        <b-card>
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
    </b-row>
    <Dialog ref="msg"></Dialog>
  </div>
</template>

<script>
import { getMemberTree, jstree_ajax_data } from "../../../system/api/api";
import Dialog from "../../../components/dialog.vue";
import { handleError } from "../../../system/handleRes";
import { mapGetters } from "vuex";
import VJstree from "vue-jstree";
export default {
  computed: {
    ...mapGetters(["lang"]),
  },
  components: {
    Dialog,
    VJstree,
  },
  data() {
    return {
      username: "",
      editingItem: {},
      editingNode: null,
      canClear: false,
      parent: "#",
      uid: "",
      asyncData: [],
      testData: [],
    };
  },
  methods: {
    loadData: async function (oriNode, resolve) {
      var data;
      if (oriNode.data.id) {
        data = await this.getTreeData(oriNode.data.id);
      } else {
        data = await this.loadItems();
      }

      if (data) {
        resolve(data);
      }
    },
    onSearch() {
      this.pageNumber = 1;
      if (this.username != "") {
        this.canClear = true;
      }
      this.asyncData = [this.$refs.tree.initializeLoading()];
      this.$refs.tree.handleAsyncLoad(this.asyncData, this.$refs.tree);
    },
    onCancel() {
      this.username = "";
      this.canClear = false;
      this.asyncData = [this.$refs.tree.initializeLoading()];
      this.$refs.tree.handleAsyncLoad(this.asyncData, this.$refs.tree);
    },
    async getTreeData(parent) {
      var result = jstree_ajax_data(
        parent == null ? encodeURIComponent("#") : parent,
        this.uid
      );
      var self = this;
      this.isLoading = true;
      var data = [];
      data = await result
        .then(function (value) {
          var tmpData = [];
          var returnData = value.data;
          for (let i = 0; i < returnData.length; i++) {
            var tmap = {};
            tmap["id"] = returnData[i]["id"];
            tmap["text"] = returnData[i]["text"];
            tmap["icon"] = returnData[i]["icon"];
            tmap["isLeaf"] = !returnData[i]["children"];
            tmpData.push(tmap);
          }
          self.loading = false;
          return tmpData;
        })
        .catch(function (error) {
          if (error.length > 0) {
            self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
          }
        });
      return data;
    },

    async loadItems() {
      var result = getMemberTree(this.username);
      var self = this;
      this.isLoading = true;
      var returnData;
      returnData = await result
        .then(async function (value) {
          self.uid = value.data.data.uid;
          self.testData = await self.getTreeData();
          return self.testData;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
      return returnData;
    },
  },
  watch: {},
};
</script>

<style>
.hiddenClass {
  pointer-events: none;
  display: none;
}

.no_checkbox > i.tree-checkbox {
  display: none;
}

.bodyWidth {
  min-width: 120px;
}

.dateWidth {
  min-width: 100px;
}
</style>