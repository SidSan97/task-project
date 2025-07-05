// import { App } from 'vue'

declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
      $loading: {
        show: () => Promise<any>
        progress: (text: string, progress: string) => Promise<any>
        hide: () => Promise<any>
      }
    }
  }
  
  export default {
    install(app?: any, options?: unknown) {
      app.config.globalProperties.$loading = {
        show() {
          return new Promise((resolve) => {
            if (document.getElementById('loader') != null) return resolve("")
  
            const div = document.createElement('div')
            div.id = 'loader'
  
            div.innerHTML = `<div class="content"><div class="loading-icon">Carregando...</div></div>`
  
            document.body.appendChild(div)
            resolve("")
          })
        },
  
        progress(text = '', progress = '') {
          return new Promise((resolve) => {
            if (document.getElementById('loader') != null) {
              const icon = document.querySelector('.load .loading-icon') as HTMLElement
              icon.innerHTML = progress
              const legend = document.querySelector('.content p') as HTMLElement
              legend.innerHTML = text
              return resolve("")
            }
  
            const div = document.createElement('div')
            div.id = 'loader'
  
            div.innerHTML = `<div class="content">
              <div class="load">
                <div class="loading-icon">${progress}</div>
              </div>
              <p>${text}</p>
            </div>`
  
            document.body.appendChild(div)
            resolve("")
          })
        },
  
        hide() {
          return new Promise((resolve) => {
            const elem = document.getElementById('loader') as HTMLElement
            if (elem != null) {
              document.body.removeChild(elem)
            }
            resolve("")
          })
        }
      }
    }
}
  