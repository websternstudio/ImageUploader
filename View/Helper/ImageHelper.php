<?php
App::uses('Helper', 'View');

class ImageHelper extends Helper {
    var $helpers = array('Html', 'Form');

    /**
     * Ajoute une string à la fin du nom de l'image
     *
     * @param  string $image        chemin de l'image
     * @param  string $append       string à ajouter
     * @param  string $defaultImage image par defaut
     * @return string               chemin de l'image
     */
    public function imagePath($image, $append = '', $defaultImage = null) {
        $newPath = null;

        if (empty($image)) {
            $newPath = $defaultImage;
        }
        else {
            $path = explode('.', $image);
            $newPath = $path[0] . $append . '.' . $path[1];
        }

        return $newPath;
    }

    /**
     * Génère un formulaire pour uploader une image
     *
     * @param  string $name      nom du champ
     * @param  string $image     url de l'image actuel
     * @param  array  $uploadURL url pour uploader l'imgae
     * @param  array  $deleteURL url pour supprimer l'image si null alors il n'y pas de bouton supprimer
     * @param  array  $options   [description]
     * @return string            formulaire html
     */
    public function form($name, $image, $uploadURL, $deleteURL, $options = array()) {
        $imageOptions = array();
        if (array_key_exists('id', $options)) {
            $imageOptions['id'] = $options['id'];
        }

        if (array_key_exists('class', $options)) {
            $imageOptions['class'] = $options['class'];
        }

        $label = __('Choisir');
        if (array_key_exists('label', $options)) {
            $label = $options['label'];
        }

        $html  = '<div class="iu-container">';

        if(is_null($image)) {
            $html .= '<img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" class="js-image-upload">';
        } else {
            $html .= $this->Html->image($image, $imageOptions);
        }

        $html .= $this->Form->create($uploadURL['controller'], array('type' => 'file', 'url' => $uploadURL));
        $html .= '<span class="iu-button">';
        $html .= $label;
        $html .= $this->Form->input($name, array('type' => 'file', 'div' => false, 'label' => false));
        $html .= '</span>';
        $html .= $this->Form->end(array('label' => 'Envoyer'));
        if ($deleteURL !== null) {
            $html .= $this->Html->link(__('Supprimer'), $deleteURL, array('class' => 'iu-delete'));
        }
        $html .= '</div>';

        return $html;
    }

}
