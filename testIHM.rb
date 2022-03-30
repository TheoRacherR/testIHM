require 'watir'

class Article
    def initialize(title, content)
        @title = title
        @content = content
    end
    def get_title
        @title
    end
    def get_content
        @content
    end
end

b = Watir::Browser.new

b.goto '127.0.0.1:8000/'

# Création article / Edition article / Suppression article
def scenario_1(b)
    b.a(id: 'add-article').click
    article = Article.new('Mon premier article', 'Un contenu de qualité')
    b.text_field(id: 'add_article_form_title').set article.get_title
    b.textarea(id: 'add_article_form_content').set article.get_content
    b.button(id: 'add_article_form_save').click
    b.a(id: 'back-articles').click
    b.a(class: 'article-edit').click
    edit_article = Article.new('Mon premier article modifié', 'Un contenu super mais modifié')
    b.text_field(id: 'edit_article_form_title').set edit_article.get_title
    b.textarea(id: 'edit_article_form_content').set edit_article.get_content
    b.button(id: 'edit_article_form_save').click
    b.a(id: 'back-articles').click
    b.a(class: 'article-delete').click
end

def scenario_2(b)
    b.a(id: 'add-article').click
    article = Article.new('', '')
    b.text_field(id: 'add_article_form_title').set article.get_title
    b.textarea(id: 'add_article_form_content').set article.get_content
    b.button(id: 'add_article_form_save').click
    b.a(id: 'back-articles').click
    b.a(class: 'article-edit').click
    edit_article = Article.new('', '')
    b.text_field(id: 'edit_article_form_title').set edit_article.get_title
    b.textarea(id: 'edit_article_form_content').set edit_article.get_content
    b.button(id: 'edit_article_form_save').click
    b.a(id: 'back-articles').click
    b.a(class: 'article-delete').click
end

def scenario_3(b)
    b.a(id: 'add-article').click
    article = Article.new("0" * 260, 'Un contenu de qualité')
    b.text_field(id: 'add_article_form_title').set article.get_title
    b.textarea(id: 'add_article_form_content').set article.get_content
    b.button(id: 'add_article_form_save').click
    b.a(id: 'back-articles').click
    b.a(class: 'article-edit').click
    edit_article = Article.new('', '')
    b.text_field(id: 'edit_article_form_title').set edit_article.get_title
    b.textarea(id: 'edit_article_form_content').set edit_article.get_content
    b.button(id: 'edit_article_form_save').click
    b.a(id: 'back-articles').click
    b.a(class: 'article-delete').click
end

scenario_3(b)