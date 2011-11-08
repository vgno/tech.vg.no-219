<?php
/**
 * Article route
 */
class Application_Controller_Router_Route_Article extends Zend_Controller_Router_Route_Regex {
    /**
     * Available articles
     *
     * This should of course be dealt with in some other way, but that is a completely different
     * post on the blog...
     *
     * @var array
     */
    private $articles = array(
        1 => 'correct-title',
        2 => 'some-other-title',
        3 => 'a-third-article',
    );

    /**
     * Match method
     *
     * @param string $path The accessed path
     * @param boolean $partial Whether the route is a part of a chain or not
     * @return array Return an array that will eventually end up in the request instance as
     *               parameters
     */
    public function match($path, $partial = false) {
        $match = parent::match($path, $partial);

        if ($match) {
            $id = (int) $match['id'];

            // See if the accessed article actually exist
            if (!isset($this->articles[$id])) {
                throw new Zend_Controller_Router_Exception('Article with id ' . $id . ' does not exist', 404);
            }

            // Create an article object
            $article = new stdClass();
            $article->id = $id;
            $article->title = $this->articles[$id];

            // Add article to the match array so it gets put in the request object
            $match['article'] = $article;

            // Overwrite the title currently matched so that the redirector plugin will use the
            // correct data when assembling this route
            $match['title'] = $this->articles[$id];
        }

        return $match;
    }
}
