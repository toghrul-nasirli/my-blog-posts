<template>
  <div>
    <h2 class="mt-4">Add New Post</h2>
    <form @submit.prevent="savePost()">
      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" v-model="post.title" />
      </div>
      <div class="form-group">
        <label for="body">Body</label>
        <textarea
          type="password"
          class="form-control"
          style="resize: none;"
          id="body"
          v-model="post.body"
        ></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <h2 class="mt-4">Posts</h2>

    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
        <li class="page-item" v-bind:class="[{ disabled: !pagination.prevPage }]">
          <a class="page-link" href="#" @click="fetchPosts(pagination.prevPage)">Previous</a>
        </li>
        <li class="page-item">
          <span
            class="page-link text-dark"
          >Page {{ pagination.currentPage }} of {{ pagination.lastPage }}</span>
        </li>
        <li class="page-item" v-bind:class="[{ disabled: !pagination.nextPage }]">
          <a class="page-link" href="#" @click="fetchPosts(pagination.nextPage)">Next</a>
        </li>
      </ul>
    </nav>

    <div class="card mb-3" v-for="post in posts" v-bind:key="post.id">
      <div class="card-body">
        <h5 class="card-title">{{ post.id }}. {{ post.title }}</h5>
        <p class="card-text">{{ post.body }}</p>
        <a href="#" class="btn btn-danger" @click="deletePost(post.id)">Delete</a>
        <button type="submit" class="btn btn-warning" @click="updatePost(post)">Edit</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      posts: [],
      post: {
        id: "",
        title: "",
        body: ""
      },
      post_id: "",
      pagination: [],
      update: false
    };
  },

  created() {
    this.fetchPosts();
  },

  methods: {
    fetchPosts(page_url) {
      page_url = page_url || "/api/posts";

      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.posts = res.data;
          this.makePagination(res.meta, res.links);
        })
        .catch(error => console.log(error));
    },
    makePagination(meta, links) {
      let pagination = {
        currentPage: meta.current_page,
        lastPage: meta.last_page,
        nextPage: links.next,
        prevPage: links.prev
      };

      this.pagination = pagination;
    },
    savePost() {
      if (this.update == false) {
        fetch("/api/post", {
          method: "POST",
          body: JSON.stringify(this.post),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(res => {
            this.post.title = "";
            this.post.body = "";
            alert("Post Added");
            this.fetchPosts();
          })
          .catch(error => console.log(error));
      } else {
        fetch("/api/post", {
          method: "PUT",
          body: JSON.stringify(this.post),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(res => {
            this.post.title = "";
            this.post.body = "";
            alert("Post Updated");
            this.fetchPosts();
          })
          .catch(error => console.log(error));
      }
    },
    updatePost(post) {
      this.update = true;
      this.post.id = post.id;
      this.post.post_id = post.id;
      this.post.title = post.title;
      this.post.body = post.body;
    },
    deletePost(post_id) {
      if (confirm("Are You Sure?")) {
        fetch(`api/post/${post_id}`, {
          method: "delete"
        })
          .then(res => res.json())
          .then(res => {
            this.fetchPosts();
          })
          .catch(error => console.log(error));
      }
    }
  }
};
</script>
