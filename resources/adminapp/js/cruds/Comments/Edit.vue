<template>
  <div class="container-fluid">
    <form @submit.prevent="submitForm">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">edit</i>
              </div>
              <h4 class="card-title">
                {{ $t('global.edit') }}
                <strong>{{ $t('cruds.comment.title_singular') }}</strong>
              </h4>
            </div>
            <div class="card-body">
              <back-button></back-button>
            </div>
            <div class="card-body">
              <bootstrap-alert />
              <div class="row">
                <div class="col-md-12">
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.comment,
                      'is-focused': activeField == 'comment'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.comment.fields.comment')
                    }}</label>
                    <textarea
                      class="form-control"
                      rows="5"
                      :value="entry.comment"
                      @input="updateComment"
                      @focus="focusField('comment')"
                      @blur="clearFocus"
                    ></textarea>
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.commenter,
                      'is-focused': activeField == 'commenter'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.comment.fields.commenter')
                    }}</label>
                    <input
                      class="form-control"
                      type="number"
                      step="1"
                      :value="entry.commenter"
                      @input="updateCommenter"
                      @focus="focusField('commenter')"
                      @blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.commentable,
                      'is-focused': activeField == 'commentable'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.comment.fields.commentable')
                    }}</label>
                    <input
                      class="form-control"
                      type="number"
                      step="1"
                      :value="entry.commentable"
                      @input="updateCommentable"
                      @focus="focusField('commentable')"
                      @blur="clearFocus"
                      required
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <vue-button-spinner
                class="btn-primary"
                :status="status"
                :isLoading="loading"
                :disabled="loading"
              >
                {{ $t('global.save') }}
              </vue-button-spinner>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  data() {
    return {
      status: '',
      activeField: ''
    }
  },
  computed: {
    ...mapGetters('CommentsSingle', ['entry', 'loading'])
  },
  beforeDestroy() {
    this.resetState()
  },
  watch: {
    '$route.params.id': {
      immediate: true,
      handler() {
        this.resetState()
        this.fetchEditData(this.$route.params.id)
      }
    }
  },
  methods: {
    ...mapActions('CommentsSingle', [
      'fetchEditData',
      'updateData',
      'resetState',
      'setComment',
      'setCommenter',
      'setCommentable'
    ]),
    updateComment(e) {
      this.setComment(e.target.value)
    },
    updateCommenter(e) {
      this.setCommenter(e.target.value)
    },
    updateCommentable(e) {
      this.setCommentable(e.target.value)
    },
    submitForm() {
      this.updateData()
        .then(() => {
          this.$router.push({ name: 'comments.index' })
          this.$eventHub.$emit('update-success')
        })
        .catch(error => {
          this.status = 'failed'
          _.delay(() => {
            this.status = ''
          }, 3000)
        })
    },
    focusField(name) {
      this.activeField = name
    },
    clearFocus() {
      this.activeField = ''
    }
  }
}
</script>
